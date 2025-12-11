<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SuperAdmin\CustomController;
use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\Pharmacy;
use App\Models\Setting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('medicine_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $pharmacy = Pharmacy::where('user_id', auth()->user()->id)->first();
        $medicines = Medicine::where('pharmacy_id', $pharmacy->id)->orderBy('id', 'DESC')->get();
        $currency = Setting::first()->currency_symbol;

        return view('pharmacyAdmin.medicine.medicine', compact('medicines', 'currency'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('medicine_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $pharmacy = Pharmacy::where('user_id', auth()->user()->id)->first();
        $categories = MedicineCategory::whereStatus(1)->get();

        return view('pharmacyAdmin.medicine.create_medicine', compact('pharmacy', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|max:255|unique:medicine',
            'incoming_stock' => 'bail|required|numeric',
            'price_pr_strip' => 'bail|required|numeric',
            'number_of_medicine' => 'bail|required|numeric',
            'description' => 'bail|required',
            'works' => 'bail|required',
            'image' => 'bail|mimes:jpeg,png,jpg|max:1000',
        ],
            [
                'image.max' => 'The Image May Not Be Greater Than 1 MegaBytes.',
            ]);
        $data = $request->all();
        $data['total_stock'] = $data['incoming_stock'];
        if ($request->hasFile('image')) {
            $data['image'] = (new CustomController)->imageUpload($request->image);
        } else {
            $data['image'] = 'prod_default.png';
        }
        if (isset($data['title'])) {
            $meta_info = [];
            for ($i = 0; $i < count($data['title']); $i++) {
                $temp['title'] = $data['title'][$i];
                $temp['desc'] = $data['desc'][$i];
                array_push($meta_info, $temp);
            }
            $data['meta_info'] = json_encode($meta_info);
        }
        Medicine::create($data);

        return redirect('medicines')->withStatus(__('Medicines created successfully..!!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('medicine_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $medicine = Medicine::find($id);
        $pharmacy = Pharmacy::find($medicine->pharmacy_id);
        $categories = MedicineCategory::whereStatus(1)->get();

        return view('pharmacyAdmin.medicine.edit_medicine', compact('medicine', 'pharmacy', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'bail|required|max:255|unique:medicine,name,'.$id.',id',
            'price_pr_strip' => 'bail|required|numeric',
            'number_of_medicine' => 'bail|required|numeric',
            'description' => 'bail|required',
            'works' => 'bail|required',
            'image' => 'bail|mimes:jpeg,png,jpg|max:1000',
        ],
            [
                'image.max' => 'The Image May Not Be Greater Than 1 MegaBytes.',
            ]);
        $id = Medicine::find($id);
        $data = $request->all();
        if ($request->hasFile('image')) {
            (new CustomController)->deleteFile($id->image);
            $data['image'] = (new CustomController)->imageUpload($request->image);
        }
        if (isset($data['title'])) {
            $meta_info = [];
            for ($i = 0; $i < count($data['title']); $i++) {
                $temp['title'] = $data['title'][$i];
                $temp['desc'] = $data['desc'][$i];
                array_push($meta_info, $temp);
            }
            $data['meta_info'] = json_encode($meta_info);
        }
        $id->update($data);

        return redirect('medicines')->withStatus(__('Medicines updated successfully..!!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('medicine_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $medicine = Medicine::find($id);
        (new CustomController)->deleteFile($medicine->image);
        $medicine->delete();

        return response(['success' => true]);
    }
}
