<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SearchSubject;
use App\Http\Requests\V1\StoreSubject;
use App\Http\Requests\V1\UpdateSubject;
use App\Http\Resources\V1\SubjectResource;
use App\Models\Subject;
use App\Repositories\Subject\SubjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group 7. Subject
 *
 * APIs for subject management
 */
class SubjectController extends Controller
{
    private $subjectRepository;

    /**
     * SubjectController constructor.
     *
     * @param SubjectRepositoryInterface $subjectRepository
     */
    public function __construct(SubjectRepositoryInterface $subjectRepository) {
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * Get Subjects
     *
     * Get a list of all subjects.
     *
     * @responseFile responses/subject/subjects.json
     *
     * @param SearchSubject $request
     * @return Response
     */
    public function index(SearchSubject $request)
    {
        return  SubjectResource::collection($this->subjectRepository->getAll($request->all()));
    }

    /**
     * Create Subject
     *
     * Create a new subject.
     *
     * @bodyParam name string required The name of a subject Example: English
     * @bodyParam order int The order number of a subject item Example: 1
     *
     * @responseFile 201 responses/subject/subject.json
     *
     * @response 500 {
     *   "errors": [
     *     "Could not create subject. Please try again later."
     *   ]
     * }
     *
     * @param StoreSubject $request
     * @return Response
     */
    public function store(StoreSubject $request)
    {
        $data = $request->validated();
        $subject = $this->subjectRepository->create($data);

        if ($subject) {
            return response([
                'subject' => new SubjectResource($subject),
            ], 201);
        }

        return response([
            'errors' => ['Could not create subject. Please try again later.'],
        ], 500);
    }

    /**
     * Get Subject
     *
     * Get the specified subject.
     *
     * @urlParam subject required The Id of a subject item Example: 1
     *
     * @responseFile responses/subject/subject.json
     *
     * @param Subject $subject
     * @return Response
     */
    public function show(Subject $subject)
    {
        return response([
            'subject' => new SubjectResource($subject),
        ], 200);
    }

    /**
     * Update Subject
     *
     * Update the specified subject.
     *
     * @urlParam subject required The Id of a subject Example: 1
     * @bodyParam name string required The name of a subject Example: English
     * @bodyParam order int The order number of a subject item Example: 1

     * @responseFile responses/subject/subject.json
     *
     * @response 500 {
     *   "errors": [
     *     "Failed to update subject."
     *   ]
     * }
     *
     * @param Request $request
     * @param Subject $subject
     * @return Response
     */
    public function update(UpdateSubject $request, Subject $subject)
    {
        $data = $request->validated();
        $isUpdated = $this->subjectRepository->update($data, $subject->id);

        if ($isUpdated) {
            return response([
                'subject' => new SubjectResource($this->subjectRepository->find($subject->id)),
            ], 200);
        }

        return response([
            'errors' => ['Failed to update subject.'],
        ], 500);
    }

    /**
     * Remove Subject
     *
     * Remove the specified subject.
     *
     * @urlParam subject required The Id of a subject item Example: 1
     *
     * @response {
     *   "message": "Subject has been deleted successfully."
     * }
     *
     * @response 500 {
     *   "errors": [
     *     "Failed to delete subject."
     *   ]
     * }
     *
     * @param Subject $subject
     * @return Response
     */
    public function destroy(Subject $subject)
    {
        $isDeleted = $this->subjectRepository->delete($subject->id);

        if ($isDeleted) {
            return response([
                'message' => 'Subject has been deleted successfully.',
            ], 200);
        }

        return response([
            'errors' => ['Failed to delete subject.'],
        ], 500);
    }
}
