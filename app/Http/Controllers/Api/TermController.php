<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TermRequest;
use App\Models\Term;
use App\Models\Subject;
use App\Models\Specialization;
use App\Http\Controllers\Api\JsonResponse;

use App\Http\Resources\TermResource;
use App\Http\Resources\TermsResourcee;
use Exception;

class TermController extends Controller
{
    use JsonResponse;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TermRequest $request)
    {
        try {
            $term=Term::create([
                'term_name'=>$request->term_name,
                'specialization_id'=>$request->specialization_id
            ]);
            return $this->successResponse('Term Added Successfully');

        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TermRequest $request, $id)
    {
        try {
            $term = Term::findOrFail($id);

            $term->term_name =  $request->term_name;
            $term->specialization_id =  $request->specialization_id;
            $term->save();

            return $this->successResponse('Updated Term Successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $term = Term::findOrFail($id);
            $term->delete();

            return $this->successResponse('Deleted Term Successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
    }


    public function getTerm($specialization){
        try{
            // $subject=Specialization::findOrFail($specialization);
            $specialization=Specialization::findOrFail($specialization);
            $terms=$specialization->terms()->get();
            return $this->successResponse('All Terms Available For this Subject',TermsResourcee::collection($terms));
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
    }

    public function getAllTerms(){
        try{
            $terms=Term::all();
            return $this->successResponse('All Terms Available',TermsResourcee::collection($terms));
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
    }




}
