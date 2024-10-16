<?php

namespace App\Http\Controllers;

use App\Models\VideoGallery;
use Illuminate\Http\Request;
use App\Http\Resources\VideoGalleryResources;

class VideoGalleryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/videoGallery",
     *     tags={"Abubakirov"},
     *     summary="Get all videos in the gallery",
     *     description="Returns a collection of video resources filtered by project ID 2.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property()
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No videos found for the specified project",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function index()
    {
        return ['videoGallery' => VideoGalleryResources::collection(VideoGallery::all()->where('project_id', '=', 2))];
    }

    /**
     * @OA\Get(
     *     path="/api/videoGallery/{id}",
     *     tags={"Abubakirov"},
     *     summary="Get a specific video from the gallery",
     *     description="Returns a video resource for the specified ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the video",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property()
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Video not found",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function show(int $id)
    {
        return  ['videoGallery' => new VideoGalleryResources(VideoGallery::findOrFail($id))];
    }
}
