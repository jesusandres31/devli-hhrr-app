<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CandidateController extends Controller
{
    public function index()
    {
        $candidates = Candidate::all();
        return $this->jsonResponse(['candidates' => $candidates], 200);
    }

    public function store(Request $request)
    {
        $validator = $this->validateCandidate($request->all());

        if ($validator->fails()) {
            return $this->jsonResponse($validator->errors(), 400, 'Validation error');
        }

        $candidate = Candidate::create($request->all());
        return $this->jsonResponse($candidate, 201, 'Candidate created successfully');
    }

    public function show($id)
    {
        $candidate = Candidate::find($id);

        if (!$candidate) {
            return $this->jsonResponse(null, 404, 'Candidate not found');
        }

        return $this->jsonResponse(['candidate' => $candidate], 200);
    }

    public function destroy($id)
    {
        $candidate = Candidate::find($id);

        if (!$candidate) {
            return $this->jsonResponse(null, 404, 'Candidate not found');
        }

        $candidate->delete();
        return $this->jsonResponse(null, 200, 'Candidate deleted successfully');
    }

    public function update(Request $request, $id)
    {
        $candidate = Candidate::find($id);

        if (!$candidate) {
            return $this->jsonResponse(null, 404, 'Candidate not found');
        }

        $validator = $this->validateCandidate($request->all(), $id);

        if ($validator->fails()) {
            return $this->jsonResponse($validator->errors(), 400, 'Validation error');
        }

        $candidate->update($request->all());
        return $this->jsonResponse($candidate, 200, 'Candidate updated successfully');
    }

    public function updatePartial(Request $request, $id)
    {
        $candidate = Candidate::find($id);

        if (!$candidate) {
            return $this->jsonResponse(null, 404, 'Candidate not found');
        }

        $validator = $this->validateCandidate($request->all(), $id);

        if ($validator->fails()) {
            return $this->jsonResponse($validator->errors(), 400, 'Validation error');
        }

        foreach ($request->all() as $key => $value) {
            if ($request->has($key)) {
                $candidate->$key = $value;
            }
        }

        $candidate->save();
        return $this->jsonResponse($candidate, 200, 'Candidate updated partially');
    }

    /**
     * Validate candidate data.
     *
     * @param array $data
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validateCandidate(array $data, $id = null)
    {
        return Validator::make($data, [
            'first_name' => 'sometimes|required|max:255',
            'last_name' => 'sometimes|required|max:255',
            'year_of_birth' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'email' => 'sometimes|required|email|unique:candidates,email,' . $id,
            'phone' => 'nullable|max:15',
            'resume_url' => 'nullable|url',
            'resume_file' => 'nullable|string',
            'position_applied' => 'nullable|max:255',
            'status' => 'nullable|in:pending,reviewed,accepted,rejected',
            'interview_date' => 'nullable|date',
            'source_url' => 'nullable|url',
            'notes' => 'nullable|string',
        ]);
    }

    /**
     * Format JSON responses.
     *
     * @param mixed $data
     * @param int $status
     * @param string|null $message
     * @return \Illuminate\Http\JsonResponse
     */
    private function jsonResponse($data, $status = 200, $message = null)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $status
        ], $status);
    }
}
