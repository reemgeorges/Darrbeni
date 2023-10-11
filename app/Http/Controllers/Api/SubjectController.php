<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Models\Specialization;
use App\Models\Subject;
use Exception;

class SubjectController extends Controller
{
    use JsonResponse;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectRequest $request)
    {
        try {
            Subject::create([
                'name' => $request->name,
                'Specialization_id' => $request->Specialization_id,
            ]);

            return $this->successResponse('Created Subject Successfully');
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
    public function update(SubjectRequest $request, $id)
    {
        try {
            $subject = Subject::findOrFail($id);
            $res = $subject->update([
                'name'=>$request->name ?? $subject->name,
                'Specialization_id'=>$request->Specialization_id ?? $subject->Specialization_id
            ]);

            return $this->successResponse('Updated Subject Successfully');
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
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
        try {
            $subject = Subject::findOrFail($id);
            $subject->delete();

            return $this->successResponse('Deleted Subject Successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
    }

    public function showMasterOrGraduationSubjects($type)
{
    $user = auth()->user();
    $specialization = $user->code->specialization;

    if ($specialization) {
        $subjects = $specialization->subjects();

        if ($type == 'master') {
            $subjects = $subjects->where('has_master', true);
            $message = 'Filter Master Subjects';
        } else {
            $subjects = $subjects->where('has_graduation', true);
            $message = 'Filter Graduation Subjects';
        }

        $res = $subjects->get();

        $subjectResources = [];
        foreach ($res as $subject) {
            $subjectResources[] = [
                'id' => $subject->id,
                'uuid' => $subject->uuid,
                'name' => $subject->name,
                'specialization_id' => $subject->Specialization_id,
                'specialization_id' => $specialization->id,
            ];
        }

        return $this->successResponse($message, $subjectResources);
    }

    return $this->successResponse('No Specialization Found');
}

public function showSubjects($id)
{
    $specialization = Specialization::findOrFail($id);
    $subjects = $specialization->subjects()->get();

    $subjectResources = [];
    foreach ($subjects as $subject) {
        $moreOption = $subject->has_master || $subject->has_graduation ? 1 : 0;
        $subjectResources[] = [
            'id' => $subject->id,
            'uuid' => $subject->uuid,
            'name' => $subject->name,
            'specialization_id' => $subject->Specialization_id,
            'specialization_id' => $specialization->id,
        ];
    }

    return $this->successResponse('All Subjects For Specialization', $subjectResources);
}
}
