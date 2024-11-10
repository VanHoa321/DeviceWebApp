<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeviceType;
use App\Repositories\DeviceType\DeviceTypeInterface;
use Illuminate\Support\Facades\Validator;

class DeviceTypeController extends Controller
{
    protected $dtypeRepository;

    public function __construct(DeviceTypeInterface $dtypeRepository)
    {
        $this->dtypeRepository = $dtypeRepository;
    }

    public function index()
    {
        $deviceTypes = $this->dtypeRepository->all();
        return view("admin.pages.device-type.list_dtypes", compact("deviceTypes"));
    }

    public function create()
    {
        return view("admin.pages.device-type.create_dtype");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:device_types,name',
            'description' => 'max:255',
        ], [
            'name.required' => 'Tên phân loại thiết bị không được để trống',
            'name.unique' => 'Tên phân loại thiết bị đã tồn tại',
            'name.max' => 'Tên phân loại thiết bị không quá 50 ký tự.',
            'description.max' => 'Mô tả thêm không quá 255 ký tự',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'name' => $request->name,
            'description'=> $request->description
        ];
        $this->dtypeRepository->store($data);
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Thêm mới loại thiết bị thành công"]);
        return redirect()->route("dtype.index");
    }

    public function edit($id)
    {
        $edit = $this->dtypeRepository->find($id);
        return view("admin.pages.device-type.edit_dtype", compact("edit"));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:device_types,name,' . $id . ',type_id',
            'description' => 'max:255',
        ], [
            'name.required' => 'Tên phân loại thiết bị không được để trống',
            'name.unique' => 'Tên phân loại thiết bị đã tồn tại',
            'name.max' => 'Tên phân loại thiết bị không quá 50 ký tự.',
            'description.max' => 'Mô tả thêm không quá 255 ký tự',
        ]);        

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = [
            'name' => $request->name,
            'description'=> $request->description
        ];
        $this->dtypeRepository->update( $id, $data );
        $request->session()->put("messenge", ["style"=>"success","msg"=>"Chỉnh sửa loại thiết bị thành công"]);
        return redirect()->route("dtype.index");
    }

    public function destroy($id)
    {
        $destroy = $this->dtypeRepository->delete($id);
        if ($destroy) {
            return response()->json(['success' => true, 'message' => 'Xóa loại thiết bị thành công']);
        } else {
            return response()->json(['danger' => false, 'message' => 'Xóa loại thiết bị không thành công'], 404);
        }
    }
}
