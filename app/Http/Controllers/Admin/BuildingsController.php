<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buildings;
use App\Models\Branch;
use App\Repositories\Building\BuildingInterface;
use App\Repositories\Branch\BranchInterface;
use Illuminate\Support\Facades\Validator;

class BuildingsController extends Controller
{
    protected $buildingRepository;
    protected $branchRepository;

    public function __construct(BuildingInterface $buildingRepository, BranchInterface $branchRepository)
    {
        $this->buildingRepository = $buildingRepository;
        $this->branchRepository = $branchRepository;
    }

    public function index()
    {
        $buildings = $this->buildingRepository->all();
        return view("admin.pages.buildings.list_buildings", compact("buildings"));
    }

    public function create()
    {
        $listBranch = $this->branchRepository->all();
        return view("admin.pages.buildings.create_buildings", compact("listBranch"));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:buildings,name',
            'branch_id' => 'required|int',
            'description' => 'max:255',
        ], [
            'name.required' => 'Tên tòa nhà không được để trống',
            'name.unique' => 'Tên tòa nhà đã tồn tại',
            'name.max' => 'Tên tòa nhà không quá 50 ký tự.',      
            'branch_id.required' => 'Thông tin là bắt buộc.',
            'description.max' => 'Mô tả thêm không quá 255 ký tự',
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'name' => $request->name,
            'branch_id'=> $request->branch_id,
            'description'=> $request->description
        ];
        $this->buildingRepository->store($data);
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Thêm mới tòa nhà thành công"]);
        return redirect()->route("buildings.index");
    }

    public function edit($id)
    {
        $listBranch = $this->branchRepository->all();
        $edit = $this->buildingRepository->find( $id );
        return view("admin.pages.buildings.edit_buildings", compact("edit", "listBranch"));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:buildings,name,' . $id . ',building_id',
            'branch_id' => 'required|int',
            'description' => 'max:255',
        ], [
            'name.required' => 'Tên tòa nhà không được để trống',
            'name.unique' => 'Tên tòa nhà đã tồn tại',
            'name.max' => 'Tên tòa nhà không quá 50 ký tự.',      
            'branch_id.required' => 'Thông tin là bắt buộc.',
            'description.max' => 'Mô tả thêm không quá 255 ký tự',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = [
            "name"=> $request->name,
            "branch_id"=> $request->branch_id,
            "description"=> $request->description
        ];
        $this->buildingRepository->update( $id, $data );
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Cập nhật tòa nhà thành công"]);
        return redirect()->route("buildings.index");
    }

    public function destroy($id)
    {
        $destroy = $this->buildingRepository->delete($id);
        if ($destroy) {
            return response()->json(['success' => true, 'message' => 'Xóa tòa nhà thành công']);
        } else {
            return response()->json(['danger' => false, 'message' => 'Xóa tòa nhà không thành công'], 404);
        }
    }
}
