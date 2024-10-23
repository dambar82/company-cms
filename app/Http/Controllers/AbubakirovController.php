<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageGalleryResources;
use App\Http\Resources\VideoGalleryResources;
use App\Models\ImageGallery;
use App\Models\VideoGallery;
use Illuminate\Http\Request;

class AbubakirovController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/abubakirov/image-gallery",
     *     tags={"Abubakirov"},
     *     summary="Get all images in the gallery",
     *     description="Returns a collection of image resources filtered by project ID 2.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property()
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No images found for the specified project",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function getAllImageGallery()
    {
        return ImageGalleryResources::collection(
            ImageGallery::whereHas('projects', function ($query) {
                $query->where('project_id', 2);
            })->get()
        );
    }

    /**
     * @OA\Get(
     *     path="/api/abubakirov/image-gallery/{id}",
     *     tags={"Abubakirov"},
     *     summary="Get a specific image from the gallery",
     *     description="Returns an image resource for the specified ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the image",
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
     *         description="Image not found",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function getImageGallery(int $id)
    {
        $imageGallery = ImageGallery::whereHas('projects', function ($query) {
            $query->where('project_id', 2);
        })->findOrFail($id);

        return new ImageGalleryResources($imageGallery);
    }

    /**
     * @OA\Get(
     *     path="/api/abubakirov/video-gallery",
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
    public function getVideos()
    {
        return VideoGalleryResources::collection(
            VideoGallery::whereHas('projects', function ($query) {
                $query->where('project_id', 2);
            })->get()
        );
    }

    /**
     * @OA\Get(
     *     path="/api/abubakirov/video-gallery/{id}",
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
    public function getVideo(int $id)
    {
        $videoGallery = VideoGallery::whereHas('projects', function ($query) {
            $query->where('project_id', 2);
        })->findOrFail($id);

        return new VideoGalleryResources($videoGallery);
    }
}
