<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageResources;
use App\Http\Resources\VideoGalleryResources;
use App\Models\Image;
use App\Models\ImageGallery;
use App\Models\VideoGallery;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MDTController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/master_dig_tech/videos",
     *     tags={"Master Digital Technologies"},
     *     summary="Все видео",
     *     description="Returns a collection of video resources filtered by project ID 3.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No videos found for the specified project",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function getVideos(): AnonymousResourceCollection
    {
        return VideoGalleryResources::collection(
            VideoGallery::query()
                ->whereHas('projects', function ($query) {
                    $query->where('project_id', 3);
                })->get()
        );
    }

    /**
     * @OA\Get(
     *     path="/api/master_dig_tech/videos/{id}",
     *     tags={"Master Digital Technologies"},
     *     summary="Видео по ID",
     *     description="Returns a video resource for the specified ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the video record",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Video record not found",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function getVideo(int $id): VideoGalleryResources
    {
        $videoGallery = VideoGallery::query()
            ->whereHas('projects', function ($query) {
                $query->where('project_id', 3);
            })->findOrFail($id);

        return new VideoGalleryResources($videoGallery);
    }

    /**
     * @OA\Get(
     *     path="/api/master_dig_tech/images",
     *     tags={"Master Digital Technologies"},
     *     summary="Все фото",
     *     description="Returns a collection of image resources filtered by project ID 3.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No images found for the specified project",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function getImages(): AnonymousResourceCollection
    {
        $galleryIds = ImageGallery::whereHas('projects', function ($query) {
            $query->where('project_id', 3);
        })->pluck('id');

        $images = Image::whereIn('image_gallery_id', $galleryIds)->get();

        return ImageResources::collection($images);
    }

    /**
     * @OA\Get(
     *     path="/api/master_dig_tech/images/{id}",
     *     tags={"Master Digital Technologies"},
     *     summary="Фото по ID",
     *     description="Returns a image for the specified ID.",
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
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Image not found",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function getImage(int $id): ImageResources
    {
        $image = Image::find($id);

        return new ImageResources($image);
    }
}
