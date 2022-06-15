<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FilmResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\V1\StoreUpdateFilmRequest;
use App\Http\Repositories\V1\FileRespository;

class FilmsController extends Controller
{

    public $film;
    public $fileRepository;

    /**
     * Create a new Film model instance.
     *
     * @param  array  $attributes
     * @return void
     */

    public function __construct(Film $film, FileRespository $fileRepository)
    {
        $this->film = $film;
        $this->fileRepository = $fileRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FilmResource::collection($this->film->latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateFilmRequest $request)
    {
        $film = $this->film->create($request->all());
        $film = $this->fileRepository->store($request, $film);
        return new FilmResource($film);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        return new FilmResource($this->film->with('comments')->where('slug', $slug)->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        return new FilmResource($this->film->where('slug', $slug)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $film = $this->film->where('slug', $slug)->first();
        $film = $film->fill($request->all());
        $film->save();
        $this->fileRepository->store($request, $film);
        return new FilmResource($film);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $this->film->where('slug', $slug)->delete();
        return response()->json([], 200);
    }
    /**
     * Search Movie based on search term.
     *
     * @param  \App\Models\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function search($param)
    {
        $search = trim($param);
        $films = $this->film->where('name', 'LIKE',  '%'.$search.'%')
        ->orWhere('ticket_price', 'LIKE',  '%'.$search.'%')
        ->orWhere('genre', 'LIKE',  '%'.$search.'%')
        ->orWhere('country', 'LIKE',  '%'.$search.'%')
        ->orWhere('release_date', 'LIKE',  '%'.$search.'%')
        ->orWhere('rating', 'LIKE',  '%'.$search.'%')
        ->latest()->get();
        return FilmResource::collection($films);
    }
}
