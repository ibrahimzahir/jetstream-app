<?php

namespace App\Http\Livewire;

use App\Models\Posts;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Post extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $title;
    public $body;
    public $photo;
    public $postId = null;
    public $newImage;

    public $showModalForm = false;

    public function showCreatePostModal()
    {
        $this->showModalForm = true;
    }

    public function updatedShowModalForm()
    {
        $this->reset();
    }

    public function storePost()
    {
        $this->validate([
          'title' =>'required',
          'body'  => 'required',
          'photo' => 'required|image|mimes:jpeg,png,jpg|max:1024'
      ]);

        $image_name = $this->photo->getClientOriginalName();
        $this->photo->storeAs('public/photos/', $image_name);
        $post = new Posts();
        $post->user_id = auth()->user()->id;
        $post->title = $this->title;
        $post->slug = Str::slug($this->title);
        $post->body = $this->body;
        $post->photo = $image_name;
        $post->save();
        $this->reset();
        session()->flash('flash.banner', 'Post created Successfully');
    }
    public function showEditPostModal($id)
    {
        $this->reset();
        $this->showModalForm = true;
        $this->postId = $id;
        $this->loadEditForm();
    }

    public function loadEditForm()
    {
        $post = Posts::findOrFail($this->postId);
        $this->title = $post->title;
        $this->body = $post->body;
        $this->newImage = $post->photo;
    }

    public function updatePost()
    {
        $this->validate([
          'title' =>'required',
          'body'  => 'required',
          'photo' => 'image|max:1024|nullable'
      ]);
        if ($this->photo) {
            Storage::delete('public/photos/', $this->newImage);
            $this->newImage = $this->photo->getClientOriginalName();
            $this->photo->storeAs('public/photos/', $this->newImage);
        }

        Post::find($this->postId)->update([
             'title' => $this->title,
             'body'  => $this->body,
             'photo' => $this->newImage
        ]);
        $this->reset();
        session()->flash('flash.banner', 'Post Updated Successfully');
    }

    public function deletePost($id)
    {
        $post = Posts::find($id);
        Storage::delete('public/photos/', $post->photo);
        $post->delete();
        session()->flash('flash.banner', 'Post Deleted Successfully');
    }
    public function render()
    {
        return view('livewire.post', [
            'posts' => Posts::orderBy('created_at', 'DESC')->paginate(5)
        ]);
    }
}