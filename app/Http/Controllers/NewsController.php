<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Http\Requests\StoreBlogPost;
use App\NewsCategories;
use App\NewsItem;
use App\User;
use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller {

	public function __construct() {

		// konstruktoriuje aprase middleware, galime pasirinkti kokioms funkcijoms jis pritaikomas
		$this->middleware( 'auth' )->except( [ 'index', 'show' ] );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
		$news = NewsItem::with( 'user')
						->with('categories')
						->with('comments')
						->orderBy( 'title' )
						->paginate( 50 );


		Log::info( $news );

		return view( 'news.index', compact( 'news' ) );

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		// gauname visas kategorijas
		$categories = Category::all();



		return view( 'news.create', compact( 'categories' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( StoreBlogPost $request ) {
		//patikriname atkeliavusi requesta

		/* laravel colective formos: https://laravelcollective.com/docs/6.0/html */


		$newsItem             = new NewsItem();
		$newsItem->title      = $request->input( 'title' );
		$newsItem->content    = $request->input( 'content' );
		$newsItem->main_image = "none";

		// gauname prisijungusio vartotojo informacija
		$newsItem->user_id = Auth::user()->id;

		$cat =$request->input('category');

		$newsItem->save();

		// Visada pries sukuriant relationship'a reikia iskviesti save() funkcija
		// nes kitu atveju naujiena dar neturi savo ID
		$newsItem->categories()->attach($cat);



		session()->flash( 'message', 'Sekmingai sukurta naujiena' );

//		session()->flash('error', 'Sekmingai sukurta naujiena');

		return redirect()->route( 'naujienos.index' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {

		/*
		Laravel eager loading:
		https://laravel.com/docs/5.8/eloquent-relationships#eager-loading
		*/
		$newsItem = NewsItem::findOrFail($id);

		/* Laravel log viewer package'as :
		https://github.com/rap2hpoutre/laravel-log-viewer
		*/
//		Log::info( $newsItem->user );

		return view( 'news.show', compact( 'newsItem' ) );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		//
		$newsItem = NewsItem::find($id);

		//$selectedCategories = $newsItem->categories->pluck('id')->toArray();


		$selectedCategories = [];
		foreach ($newsItem->categories as $cat) {
			$selectedCategories[] = $cat->id;
		}

		$categories = Category::all();

		return view('news.edit', compact(['newsItem', 'categories', 'selectedCategories']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, $id ) {
		//

		$newsItem = NewsItem::find($id);

		$newsItem->title = $request->input('title');
		$newsItem->content = $request->input('content');


		$categories = $request->input('category');

		$newsItem->categories()->sync($categories);

		$newsItem->save();

		return redirect()->back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		//
		$newsItem = NewsItem::find( $id );
		$newsItem->delete();

		// rodyti vartotojui pranesima apie sekmingai istrinta naujiena
		session()->flash( 'message', 'Sekmingai istrinta naujiena' );

		return redirect()->back();
	}

	public function authorIndex(Request $request,  $id ) {
		$user = User::with( 'news' )->find( $id );


		$order = 'title';
		if(!empty($request->input('order'))) {
			$order =$request->input('order');
		}

		$charCount = $user->totalCharacters();

		/*$newsCount = 0;
		foreach($user->news as $newsItem) {
			// suzinau koks yra naujienos turinio ilgis
			// ir pridedu prie bendro kintamojo, kur saugau informacija
			$newsCount += strlen($newsItem->content);
		}*/

		return view( 'news.author', compact( ['user', 'order'] ) );
	}
}
