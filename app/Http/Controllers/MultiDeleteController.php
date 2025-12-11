<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SuperAdmin\CustomController;
use App\Models\Appointment;
use App\Models\Category;
use App\Models\Doctor;
use App\Models\Expertise;
use App\Models\Hospital;
use App\Models\HospitalGallery;
use App\Models\Lab;
use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\Offer;
use App\Models\Pathology;
use App\Models\PathologyCategory;
use App\Models\Pharmacy;
use App\Models\Radiology;
use App\Models\RadiologyCategory;
use App\Models\Report;
use App\Models\Treatments;
use App\Models\User;
use Illuminate\Http\Request;

class MultiDeleteController extends Controller
{
    public function category_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $category = Category::find($id);
            $category->delete();
        }

        return response(['success' => true]);
    }

    public function appointment_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $appointment = Appointment::find($id);
            $appointment->delete();
        }

        return response(['success' => true]);
    }

    public function treatment_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $treat = Treatments::find($id);
            (new CustomController)->deleteFile($treat->image);
            $treat->delete();
        }

        return response(['success' => true]);
    }

    public function expertise_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            Expertise::find($id)->delete();
        }

        return response(['success' => true]);
    }

    public function medicineCategory_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $medicineCategory = MedicineCategory::find($id);
            $medicineCategory->delete();
        }

        return response(['success' => true]);
    }

    public function hospital_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $id = Hospital::find($id);
            $hospital_galleries = HospitalGallery::where('hospital_id', $id)->get();
            foreach ($hospital_galleries as $hospital_gallery) {
                (new CustomController)->deleteFile($hospital_gallery->image);
                $hospital_gallery->delete();
            }
            (new CustomController)->deleteFile($id->image);
            $id->delete();
        }

        return response(['success' => true]);
    }

    public function doctor_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $offers = Offer::all();
            foreach ($offers as $value) {
                $doctor_id = explode(',', $value['doctor_id']);
                if (($key = array_search($id, $doctor_id)) !== false) {
                    return response(['success' => false, 'data' => 'This doctor connected with Offer, Please remove doctor from offer first.']);
                }
            }
            $id = Doctor::find($id);
            $user = User::find($id->user_id);
            $user->delete();
            (new CustomController)->deleteFile($id->image);
            $id->delete();
        }

        return response(['success' => true]);
    }

    public function pharmacy_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $pharmacy = Pharmacy::find($id);
            (new CustomController)->deleteFile($pharmacy->image);
            $user = User::find($pharmacy->user_id);
            $user->delete();
            $pharmacy->delete();
        }

        return response(['success' => true]);
    }

    public function patient_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $user = User::find($id);
            $user->delete();
        }

        return response(['success' => true]);
    }

    public function offer_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $offer = Offer::find($id);
            (new CustomController)->deleteFile($offer->image);
            $offer->delete();
        }

        return response(['success' => true]);
    }

    public function medicine_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $medicine = Medicine::find($id);
            (new CustomController)->deleteFile($medicine->image);
            $medicine->delete();
        }

        return response(['success' => true]);
    }

    public function pathology_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $pathology = Pathology::find($id);
            $reports = Report::where('lab_id', $pathology->lab_id)->get();
            foreach ($reports as $report) {
                $rs = explode(',', $report->pathology_id);
                if (in_array($id, $rs)) {
                    $report->delete();
                }
            }
            $pathology->delete();
        }

        return response(['success' => true]);
    }

    public function radiology_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $radiology = Radiology::find($id);
            $reports = Report::where('lab_id', $radiology->lab_id)->get();
            foreach ($reports as $report) {
                $rs = explode(',', $report->radiology_id);
                if (in_array($id, $rs)) {
                    $report->delete();
                }
            }
            $radiology->delete();
        }

        return response(['success' => true]);
    }

    public function lab_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $lab = Lab::find($id);
            $user = User::find($lab->user_id);
            $user->removeRole('laboratory');
            $user->delete();
            (new CustomController)->deleteFile($lab->image);
            $lab->delete();
        }

        return response(['success' => true]);
    }

    public function pathology_cat_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            PathologyCategory::find($id)->delete();
        }

        return response(['success' => true]);
    }

    public function radiology_cat_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            RadiologyCategory::find($id)->delete();
        }

        return response(['success' => true]);
    }
}
