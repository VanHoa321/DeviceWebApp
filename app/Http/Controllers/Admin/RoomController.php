<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buildings;
use App\Models\Room;
use App\Repositories\Room\RoomInterface;
use App\Repositories\Building\BuildingInterface;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{

    protected $roomRepository;
    protected $buildingRopository;

    public function __construct(RoomInterface $roomRepository, BuildingInterface $buldingRepository ) {
        $this->roomRepository = $roomRepository;
        $this->buildingRopository = $buldingRepository;
    }

    public function index()
    {
        $rooms = $this->roomRepository->all();
        return view("admin.pages.room.list_rooms", compact("rooms"));
    }

    public function create()
    {
        $listBuildings = $this->buildingRopository->all();
        return view("admin.pages.room.create_room", compact("listBuildings"));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:rooms,name',
            'building_id' => 'required|int',
            'description' => 'max:255',
        ], [
            'name.required' => 'Tên phòng không được để trống',
            'name.unique' => 'Tên phòng đã tồn tại',
            'name.max' => 'Tên phòng không quá 50 ký tự.',      
            'building_id.required' => 'Thông tin là bắt buộc.',
            'description.max' => 'Mô tả thêm không quá 255 ký tự',
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = [
            'name' => $request->name,
            'building_id'=> $request->building_id,
            'description'=> $request->description
        ];
        $this->roomRepository->store($data);
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Thêm mới phòng thành công"]);
        return redirect()->route("room.index");
    }

    public function edit($id)
    {
        $listBuildings = $this->buildingRopository->all();
        $edit = $this->roomRepository->find($id);
        return view("admin.pages.room.edit_room", compact("edit", "listBuildings"));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'building_id' => 'required|int',
            'description' => 'max:255',
        ], [
            'name.required' => 'Tên phòng không được để trống',
            'name.max' => 'Tên phòng không quá 50 ký tự.',      
            'building_id.required' => 'Thông tin là bắt buộc.',
            'description.max' => 'Mô tả thêm không quá 255 ký tự',
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = [
            'name' => $request->name,
            'building_id'=> $request->building_id,
            'description'=> $request->description
        ];
        $this->roomRepository->update($id, $data);
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Chỉnh sửa phòng thành công"]);
        return redirect()->route("room.index");
    }

    public function destroy($id)
    {
        $destroy = $this->roomRepository->delete($id);
        if ($destroy) {
            return response()->json(['success' => true, 'message' => 'Xóa phòng thành công']);
        } else {
            return response()->json(['danger' => false, 'message' => 'Xóa phòng không thành công'], 404);
        }
    }
}
