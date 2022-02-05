<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Article;
use App\User; 
use Validator;
use App\Http\Resources\Article as ArticleResource;
   
class ArticleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user  = User::find(auth()->id());
        $articles = $user->article;
    
        return $this->sendResponse(ArticleResource::collection($articles), 'Articles retrieved successfully.');

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $requearticlest
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'text' => 'required',
            'published_at' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $article = Article::create([
            'text' => request('text'),
            'title' => request('title'),
            'published_at' => request('published_at'),
            'user_id' => auth()->id(),
        ]);
   
        return $this->sendResponse(new ArticleResource($article), 'Article created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
  
        if (is_null($article)) {
            return $this->sendError('Article not found.');
        }
   
        return $this->sendResponse(new ArticleResource($article), 'Article retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'text' => 'required',
			'published_at' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $article->title = $input['title'];
        $article->text = $input['text'];
 		$article->published_at = $input['published_at'];
        $article->save();
   
        return $this->sendResponse(new ArticleResource($article), 'Article updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
   
        return $this->sendResponse([], 'Article deleted successfully.');
    }
}
