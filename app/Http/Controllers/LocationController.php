<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use App\Models\Vaccination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{

    public function index()
    {
        $locations = Location::with(['vaccinations'])->get();
        return $locations;
    }

    public function show(Location $location)
    {
        return view('locations.show', compact('location'));
    }


    public function findById(int $id): Location
    {
        return Location::where('id', $id)
            ->with(['vaccinations'])
            ->first();

    }

    public function findByZipcode(int $zipcode): Location
    {
        return Location::where('zipcode', $zipcode)
            ->with(['vaccinations'])
            ->first();

    }

    public function checkZipcode(int $zipcode)
    {
        $location = Location::where('zipcode', $zipcode)->first();
        return $location != null ? response()
            ->json(true, 200) : response()
            ->json(false, 200);
    }

    public function findBySearchTerm(string $searchTerm)
    {
        return Location::with(['vaccinations'])
            ->where('name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('street', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('zipcode', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('city', 'LIKE', '%' . $searchTerm . '%')
            ->orWhereHas('vaccinations', function ($query) use ($searchTerm)
            {
                $query
                    ->where('time', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('date', 'LIKE', '%' . $searchTerm . '%');
            })->get();
    }

    public function delete(string $id) : JsonResponse
    {
        $location = Location::where('id', $id)->first();
        if ($location != null) {
            $location->delete();
        }
        else
            throw new \Exception("location couldn't be deleted - it does not exist");
        return response()->json('location (' . $id . ') successfully deleted', 200);
    }

    public function save(Request $request): JsonResponse
    {

        $request = $this->parseRequest($request);
        DB::beginTransaction();
        try {
            $locations = Location::create($request->all());
            if (isset($request['vaccinations']) && is_array($request['vaccinations'])) {
                foreach ($request['vaccinations'] as $vaccination) {
                    $object =
                        Vaccination::firstOrNew([
                            'id'=>$vaccination['id'],
                            'maxUsers'=>$vaccination['maxUsers'],
                            'date'=>$vaccination['date'],
                            'time'=>$vaccination['time'],
                            'location_id'=>$vaccination['location_id'],
                            'created_at' => $vaccination['created_at'],
                            'updated_at' => $vaccination['updated_at'],
                        ]);
                    $locations->users()->save($object);
                }
            }
            DB::commit();
            // return a vaild http response
            return response()->json($locations, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("saving vaccination failed: " . $e->getMessage(), 420);
        }


        DB::commit();
        return response()->json($locations, 201);

    }


    public function update(Request $request, string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $location = Location::with(['vaccinations'])
                ->where('id', $id)->first();
            if ($location != null) {
                $request = $this->parseRequest($request);
                $location->update($request->all());
                //delete all old images
               /* $location->vaccinations()->delete();
                // save images
                if (isset($request['vaccinations']) && is_array($request['vaccinations'])) {
                    foreach ($request['vaccinations'] as $vaccination) {
                        $object =
                            Vaccination::firstOrNew([
                                'id'=>$vaccination['id'],
                                'maxUsers'=>$vaccination['maxUsers'],
                                'date'=>$vaccination['date'],
                                'time'=>$vaccination['time'],
                                'location_id'=>$vaccination['location_id'],
                                'created_at' => $vaccination['created_at'],
                                'updated_at' => $vaccination['updated_at'],
                            ]);
                        $location->vaccinations()->save($object);
                    }
                }*/

            }
            DB::commit();
            $loc = Location::with(['vaccinations'])
                ->where('id', $id)->first();
            // return a vaild http response
            return response()->json($loc, 201);
        } catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating book failed: " . $e->getMessage(), 420);
        }
    }

    private function parseRequest(Request $request): Request
    {
        $datetime = new \DateTime($request->published);
        $request['published'] = $datetime;
        return $request;
    }

}
