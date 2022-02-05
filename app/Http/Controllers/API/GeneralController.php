<?php
   
   namespace App\Http\Controllers\API;
   
   use Illuminate\Http\Request;
   use App\Http\Controllers\API\BaseController as BaseController;
   use App\Article;
   use App\User; 
   use Validator;
   use App\Http\Resources\Article as ArticleResource;
   
class GeneralController extends BaseController
{
    /**
     * General api
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $articles = Article::all()->where('created_at', '<', now())->distinct()->get();
        $articles = Article::select('title','created_at','updated_at','id')->orderBy('published_at', 'desc')->where('published_at', '<', now())->get();

        return $this->sendResponse($articles, 'Articles retrieved successfully.');

    }
   
    /**
     * General api
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
  
        if (is_null($article)) {
            return $this->sendError('Article not found.');
        }

        // if ($article->published_at > now()) {
        //     return $this->sendError('Article not found.');
        // }
   
        return $this->sendResponse(new ArticleResource($article), 'Article retrieved successfully.');
    }

    public function imageUploadPost(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $imageName = time().'.'.$request->image->extension();  
     
        $request->image->move(public_path('images'), $imageName);  
    
        return 'images/' . $imageName; 
    }
    
}