<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Comment;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManagerStatic;
use Storage;

class Comments extends Component
{   

    use WithPagination;
    use WithFileUploads;
    // use Intervention\Image\ImageManagerStatic;
    
    public $newComment;

    public $image;

    protected $listeners = ['fileUpload' => 'handleFileUpload'];

    public function handleFileUpload($imageData)
    {
        $this->image = $imageData;
    }

    public function addComment()
    {
      
        $this->validate(['newComment' => 'required|max: 255']);

        $image = $this->storeImage();

        $createComment = Comment::create(
            [
                'body' => $this->newComment,
                'user_id' => 1,
                'image' => $image
            ]);

        // $this->comments->prepend($createComment);

        $this->newComment = "";

        session()->flash('message', 'comment added successfully');
    }

    public function storeImage()
    {
        if(!$this->image) 
        {
            return null;
        }

        $img = ImageManagerStatic::make($this->image)->encode('jpg');

        Storage::put('image.jpg', $img);
    }

    public function updated($field)
    {
        $this->validateOnly($field, ['newComment' => 'required|max: 255']);
            
    }

    public function remove($commentId)
    {
        $find = Comment::find($commentId);

        $find->delete();

        // $this->comments = $this->comments->except($commentId);

        session()->flash('message', 'comment deleted successfully');

    }


    public function render()
    {   
        $comments = Comment::latest()->paginate(1);
        return view('livewire.comments', compact('comments'));
    }
}
