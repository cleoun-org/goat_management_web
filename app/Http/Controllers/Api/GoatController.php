<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Breed;
use App\Models\Goat;
use App\Models\Group;
use App\Models\User;
use App\Utils\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\File as RulesFile;
use Intervention\Image\Facades\Image;

class GoatController extends Controller
{
    public function getBreeds()
    {
        try {

            $breed = Breed::get();

            return ResponseFormatter::success($breed, "Data berhasil didapatkan");

            // ...
        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }

    public function getGoat(Request $request)
    {
        try {

            $user = auth_user();

            $goat = $user->goats()->where('tag', $request->tag)->first();

            if($goat instanceof Goat === false) {
                throw new \Exception("Pengguna tidak memiliki kambing dengan tag : " . $request->tag);
            }

            return ResponseFormatter::success($goat, "Kambing dengan tag '" . $request->tag . "' berhasil di dapatkan!");

            // ...

        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }

    public function getGoats(Request $request)
    {
        try {

            $column = $request->column;

            $user = auth_user();

            if($request->group_id == null) {
                $quee = $user->goats();
            } else {
                $quee = $user->goats()->where('group_id', "=", $request->group_id);
            }

            $val = $request->value;

            if($val === "" || $val === null) {
                $column = null;
            }

            $goats = (match($column) {
                "" => $quee,
                null => $quee,
                "name" => $quee->where("name", "LIKE", "%$val%"),
                "gender" => $quee->where("gender", "=", $val),
                "breed" => $quee->where("breed", "=", $val),
                "status" => $quee->where("status", "=", $val),
                "origin" => $quee->where("origin", "=", $val),
                "weight_less_than" => $quee->where("weight", "<", $val),
                "weight_greater_than" => $quee->where("weight", ">=", $val),
            })->paginate(10);

            return ResponseFormatter::success($goats, 'Data berhasil didapatkan!');

        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());
        }
    }

    public function addGoat(Request $request)
    {
        try {

            $request->validate([
                'name' => ['required', 'min:3', 'max:120'],
                'tag' => ['required', 'alpha_num', 'min:3'],
                'picture' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,jpg,png,webp',
                    RulesFile::image()->min(5)->max(3 * 1024),
                ],
                'gender' => ['required', 'in:female,male'],
                'origin' => ['required', 'min:3', 'max:120'],
                'breed' => ['min:3', 'max:120'],
                'status' => ['required', 'in:alive,death,sold'],
                'birth_date' => ['string', 'date'],
                'date_in' => ['required', 'string', 'date'],
                'note' => ['required', 'min:3', 'max:450'],
                'weight' => ['required', 'integer', 'max:999999'],
            ]);

            $user = auth_user();

            $father = get_goat($request->father_tag, false);

            $mother = get_goat($request->mother_tag, false);

            $group = get_group($request->group_id);

            $goat = new Goat();

            $global_tag = md5($user->id . $request->tag);

            $_res = Goat::where('global_tag', $global_tag)->first();

            if($_res instanceof Goat) {
                throw new \Exception("Tag telah di gunakan!");
            }

            $filename = null;

            if($request->picture !== null) {
                $filename = $this->saveImage($user, $global_tag, $request);
            }

            $goat->name = $request->name;
            $goat->gender = $request->gender;
            $goat->tag = $request->tag;
            $goat->global_tag = $global_tag;
            $goat->picture = $filename;
            $goat->weight = $request->weight;
            $goat->origin = $request->origin;
            $goat->breed = $request->breed;
            $goat->status = $request->status;
            $goat->birth_date = $request->birth_date;
            $goat->date_in = $request->date_in;
            $goat->note = $request->note;

            $goat->user()->associate($user);
            $goat->father()->associate($father);
            $goat->mother()->associate($mother);
            $goat->group()->associate($group);

            $goat->save();

            return ResponseFormatter::success($goat, "Kambing berhasil ditambahkan!");

            // ...
        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());
        }
    }

    public function updateGoat(Request $request)
    {
        try {

            $request->validate([
                'name' => ['required', 'min:3', 'max:120'],
                'tag' => ['required', 'alpha_num', 'min:3'],
                'picture' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,jpg,png,webp',
                    RulesFile::image()->min(5)->max(3 * 1024),
                ],
                'gender' => ['required', 'in:female,male'],
                'origin' => ['required', 'min:3', 'max:120'],
                'breed' => ['min:3', 'max:120'],
                'status' => ['required', 'in:alive,death,sold'],
                'birth_date' => ['string','date'],
                'date_in' => ['string', 'date', 'required'],
                'note' => ['required', 'min:3', 'max:450'],
                'weight' => ['required', 'integer', 'max:999999'],
            ]);

            $user = auth_user();

            $father = get_goat($request->father_tag, false);

            $mother = get_goat($request->mother_tag, false);

            $group = get_group($request->group_id);

            $global_tag = md5($user->id . $request->tag);

            $goat = $user->goats()->where('tag', $request->goat_tag)->first();

            if($goat instanceof Goat === false) {
                throw new \Exception("Anda tidak memiliki kambing dengan tag : " . $request->goat_tag);
            }

            $_res = Goat::where('global_tag', $global_tag)->first();

            if($_res instanceof Goat && $_res->id !== $goat->id) {
                throw new \Exception("Tag telah di gunakan!");
            }

            if($request->picture instanceof UploadedFile) {

                $prev_image = $user->get_storage("goats_pict" . DIRECTORY_SEPARATOR . $goat->picture);

                File::delete($prev_image);

                $filename = null;

                if($request->picture !== null) {
                    $filename = $this->saveImage($user, $global_tag, $request);
                }

                $goat->picture = $filename;
            }

            $goat->name = $request->name;
            $goat->tag = $request->tag;
            $goat->global_tag = $global_tag;
            $goat->weight = $request->weight;
            $goat->origin = $request->origin;
            $goat->breed = $request->breed;
            $goat->status = $request->status;
            $goat->gender = $request->gender;
            $goat->birth_date = $request->birth_date;
            $goat->note = $request->note;

            $goat->user()->associate($user);
            $goat->father()->associate($father);
            $goat->mother()->associate($mother);
            $goat->group()->associate($group);

            $goat->save();

            return ResponseFormatter::success($goat, "Kambing '{$request->tag}' berhasil diupdate!");

        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());
        }
    }

    public function getEvents(Request $request)
    {
        try {

            $goat = get_goat($request->goat_tag);

            $events = $goat->event;

            return ResponseFormatter::success($events, "Data event kambing berhasil di-dapatkan!");

            // ...
        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }

    public function deleteGoat(Request $request)
    {
        try {

            $goat = get_goat($request->tag, true);

            $goat->delete();

            return ResponseFormatter::success([], "Data kambing dengan tag '" . $request->tag . "' berhasil dihapus");

            // ...

        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }

    public function geGoatBreedsReport() {
        try {
            
            $user = auth_user();

            $breeds = Breed::all();

            $data = [];

            foreach($breeds as $breed) {
                $data[$breed->name] = $user->goats()->where('breed', $breed->name)->count();
            }

            return ResponseFormatter::success($data, "Laporan Kambing Breed berhasil di-dapatkan!");
            
            // ...
        } catch (\Throwable $th) {
            
            return ResponseFormatter::error([], $th->getMessage());
        }
    }

    private function saveImage(User $user, $global_tag, $request)
    {
        // store image
        $storage = $user->get_storage("goats_pict");

        $filename = $global_tag . ".jpg";

        $user_folder = $storage . DIRECTORY_SEPARATOR;

        if(!File::exists($user_folder)) {
            File::makeDirectory($user_folder);
        }

        Image::make($request->picture)->save("$user_folder$filename", 80, 'jpg');

        return $filename;
    }
}
