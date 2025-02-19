<?php

namespace App\Http\Controllers;

use App\Models\MDT\Category;
use App\Models\MDT\Service;
use App\Http\Resources\MDT\ServiceContentResource;
use App\Models\MDT\ServiceContent;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MDTController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/master_dig_tech/services",
     *     tags={"Master Digital Technologies"},
     *     summary="Все услуги",
     *     description="Returns a collection of services filtered by project ID 3.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No services found for the specified project",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function getServices(): AnonymousResourceCollection
    {
        return ServiceContentResource::collection(ServiceContent::all());
    }

    /**
     * @OA\Get(
     *     path="/api/master_dig_tech/services/{service_slug}",
     *     tags={"Master Digital Technologies"},
     *     summary="Услуга по slug",
     *     description="Returns a service resource for the specified slug.",
     *     @OA\Parameter(
     *         name="service_slug",
     *         in="path",
     *         required=true,
     *         description="Slug of the service",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function getServiceBySlug(string $serviceSlug): AnonymousResourceCollection
    {
        $serviceId = Service::where('slug', $serviceSlug)->pluck('id');
        $serviceContents = ServiceContent::whereIn('service_id', $serviceId)->get();

        return ServiceContentResource::collection($serviceContents);
    }

    /**
     * @OA\Get(
     *     path="/api/services/{service_slug}/{category_slug}",
     *     tags={"Master Digital Technologies"},
     *     summary="Получить контент по услугам и категориям",
     *     description="Возвращает контент для заданной услуги и категории.",
     *     @OA\Parameter(
     *         name="serviceSlug",
     *         in="query",
     *         required=true,
     *         description="Слаг услуги",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="categorySlug",
     *         in="query",
     *         required=true,
     *         description="Слаг категории",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="photos",
     *                 type="array",
     *                 @OA\Items()
     *             ),
     *             @OA\Property(
     *                 property="videos",
     *                 type="array",
     *                 @OA\Items()
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Услуга или категория не найдены"
     *     )
     * )
     */
    public function getContent(string $serviceSlug, string $categorySlug): AnonymousResourceCollection
    {
        $serviceId = Service::where('slug', $serviceSlug)->value('id');
        $categoryId = Category::where('slug', $categorySlug)->value('id');

        $serviceContents = ServiceContent::where('service_id', $serviceId)
            ->where('category_id', $categoryId)->get();

        return ServiceContentResource::collection($serviceContents);
    }

    public function getCategories()
    {
        return Category::all()->select('name', 'slug');
    }
}
