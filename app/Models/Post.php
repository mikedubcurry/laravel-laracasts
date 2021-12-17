<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{

  public function __construct(public $title, public $excerpt, public $date, public $body, public $slug)
  {
  }

  public static function find($slug)
  {
    return static::all()->firstWhere('slug', $slug);
  }

  public static function findOrFail($slug)
  {
    $post = static::find($slug);
    if (!$post) {
      abort(404);
    }
    return $post;
  }

  public static function all()
  {
    $posts = cache()->rememberForever("posts.all", function () {
      return collect(File::files(resource_path("posts/")))
        ->map(fn ($file) => YamlFrontMatter::parseFile($file))
        ->map(
          fn ($document) => new Post(
            $document->title,
            $document->excerpt,
            $document->date,
            $document->body(),
            $document->slug
          )
        )->sortByDesc('date');
    });

    return $posts;
  }
}
