<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vaccination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VaccinationController extends Controller
{
    public function index()
    {
        $vaccination = Vaccination::with(['users', 'location'])->get();
        return $vaccination;
    }
    public function getLocationNameFromVaccination($id)
    {
        return Vaccination::select('locations.name')
            ->leftJoin('locations','vaccinations.location_id','=','locations.id')
            ->get();
    }

    public function findById(int $id): Vaccination
    {
        return Vaccination::where('id', $id)
            ->with(['location', 'users'])
            ->first();

    }


    public function save(Request $request): JsonResponse
    {

        $request = $this->parseRequest($request);
        DB::beginTransaction();
        try {
            $vaccination = Vaccination::create($request->all());
            if (isset($request['users']) && is_array($request['users'])) {
                foreach ($request['users'] as $user) {
                    $object =
                        User::firstOrNew([
                            'firstName' => $user['firstName'],
                            'lastName' => $user['lastName'],
                            'email' => $user['email'],
                            'phone' => $user['phone'],
                            'sex' => $user['sex'],
                            'ssn' => $user['ssn'],
                            'isVaccinated' => $user['isVaccinated'],
                            'isAdmin' => $user['isAdmin'],
                            'password' => $user['password'],
                            'vaccination_id' => $user['vaccination_id'],
                            'created_at' => $user['created_at'],
                            'updated_at' => $user['updated_at'],
                        ]);
                    $vaccination->users()->save($object);
                }
            }
            DB::commit();
            // return a vaild http response
            return response()->json($vaccination, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("saving vaccination failed: " . $request['date'] . $e->getMessage(), 420);
        }


        DB::commit();
        return response()->json($vaccination, 201);

    }

    public function update(Request $request, string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $vaccination = Vaccination::with(['users'])
                ->where('id', $id)->first();
            if ($vaccination != null) {
                $request = $this->parseRequest($request);
                $vaccination->update($request->all());
                //delete all old images
/*                $vaccination->users()->delete();
                // save images
                if (isset($request['users']) && is_array($request['users'])) {
                    foreach ($request['users'] as $user) {
                        $object =
                            User::firstOrNew([
                                'id'=>$user['id'],
                                'firstName' => $user['firstName'],
                                'lastName' => $user['lastName'],
                                'email' => $user['email'],
                                'phone' => $user['phone'],
                                'sex' => $user['sex'],
                                'ssn' => $user['ssn'],
                                'isVaccinated' => $user['isVaccinated'],
                                'isAdmin' => $user['isAdmin'],
                                'password' => $user['password'],
                                'vaccination_id' => $user['vaccination_id'],
                                'created_at' => $user['created_at'],
                                'updated_at' => $user['updated_at'],
                            ]);
                        $vaccination->users()->save($object);
                    }
                }*/

            }
            DB::commit();
            $book1 = Vaccination::with(['users'])
                ->where('id', $id)->first();
            // return a vaild http response
            return response()->json($book1, 201);
        } catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating book failed: " . $e->getMessage(), 420);
        }
    }

    public function delete(string $id) : JsonResponse
    {
        $vaccination = Vaccination::where('id', $id)->first();
        if ($vaccination != null) {
            $vaccination->delete();
        }
        else
            throw new \Exception("vaccination couldn't be deleted - it does not exist");
        return response()->json('vaccination (' . $id . ') successfully deleted', 200);
    }


    private function parseRequest(Request $request): Request
    {
        $datetime = new \DateTime($request->published);
        $request['published'] = $datetime;
        return $request;
    }

//
}
