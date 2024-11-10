<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Repositories\DeviceType\DeviceTypeInterface;
use Illuminate\Http\Request;
use App\Models\DeviceType;
use App\Models\Room;
use App\Models\WorkUnit;
use App\Repositories\Device\DeviceInterface;
use App\Repositories\Room\RoomInterface;
use App\Repositories\WorkUnit\WorkUnitInterface;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    protected $deviceRepository;
    protected $dtypeRepository;
    protected $roomRepository;
    protected $unitRepository;

    public function __construct(DeviceInterface $deviceRepository, DeviceTypeInterface $dtypeRepository, RoomInterface $roomRepository, WorkUnitInterface $unitRepository)
    {
        $this->deviceRepository = $deviceRepository;
        $this->dtypeRepository = $dtypeRepository;
        $this->roomRepository = $roomRepository;
        $this->unitRepository = $unitRepository;
    }
    public function index()
    {
        $devices = $this->deviceRepository->all();
        return view("admin.pages.device.list_devices", compact("devices"));
    }


    public function create()
    {
        $types = $this->dtypeRepository->all();
        $rooms = $this->roomRepository->all();
        $units = $this->unitRepository->all();
        return view('admin.pages.device.create_device', compact('types','rooms','units'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'type_id' => 'required|int',
            'room_id' => 'required|int',
            'unit_id' => 'required|int', 
            'code' => 'required|string|max:50|unique:devices,code',
            'image' => 'required|string', 
            'years' => 'required',
            'status' => 'required',
        ], [
            'name.required' => 'Tên thiết bị không được để trống',
            'name.max' => 'Tên thiết bị không quá 50 ký tự.',
            'type_id.required' => 'Loại thiết bị là bắt buộc.',
            'room_id.required' => 'Phòng là bắt buộc.',
            'unit_id.required' => 'Đơn vị là bắt buộc.',
            'code.required' => 'Mã thiết bị không được để trống',
            'code.max' => 'Mã thiết bị không quá 50 ký tự.',
            'code.unique' => 'Mã thiết bị đã tồn tại.',
            'image.required' => 'Đường dẫn ảnh không để trống.',
            'years.required' => 'Số năm sử dụng không được để trống.',
            'status.required' => 'Trạng thái là bắt buộc.',
        ]);
    
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }    
        $data = [
            'name' => $request->name,
            'type_id' => $request->type_id,
            'room_id' => $request->room_id,
            'unit_id' => $request->unit_id,
            'code' => $request->code,
            'image' => $request->image,
            'years' => $request->years,
            'status' => $request->status,
        ];
        $this->deviceRepository->store($data);
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Thêm mới thiết bị thành công"]);
        return redirect()->route("device.index");
    }

    public function edit($id)
    {
        $device = $this->deviceRepository->find($id);
        $types = $this->dtypeRepository->all();
        $rooms = $this->roomRepository->all();
        $units = $this->unitRepository->all();
        return view('admin.pages.device.edit_device', compact('device', 'types','rooms','units'));
    }

    public function update(Request $request, $id)
    {
        $data = [
            'name' => $request->name,
            'type_id' => $request->type_id,
            'room_id' => $request->room_id,
            'unit_id' => $request->unit_id,
            'code' => $request->code,
            'image' => $request->image,
            'years' => $request->years,
            'status' => $request->status,
        ];
        $this->deviceRepository->update($id, $data);
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Chỉnh sửa thiết bị thành công"]);
        return redirect()->route("device.index");
    }

    public function destroy($id)
    {
        $destroy = $this->deviceRepository->delete($id);
        if ($destroy) {
            return response()->json(['success' => true, 'message' => 'Xóa thiết bị thành công']);
        } else {
            return response()->json(['danger' => false, 'message' => 'Xóa thiết bị không thành công'], 404);
        }
    }
}
