<?php

namespace App\Http\Livewire;
use Carbon\Carbon;
use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Comments extends Component
{
    use WithPagination;
    use WithFileUploads;

    // data binded to the input field-holds data from input
    public $newComment = '';
    //for image
    public $image;

    protected $listeners = ['fileUpload' => 'handleFileUpload'];
    public function handleFileUpload($imageData)
    {
        $this->image = $imageData;
    }
    //holds comments from db
    //commented for pagination
    // public $comments;
    
    //Get data from database and assign it to to $comments
    //commented for pagination
    // public function mount()
    // {
    //     $intialComments= Comment::all(); //$intialComments=Comment::latest()->get();
    //     $this->comments = $intialComments;
    // }
    
    // real time validation inside updated hook
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName,['newComment'=>'required|max:255']);
    }

    public function addComment(){
    //this code is replaced by validate
        // if($this->newComment == ''){
        //     return;
        // }
        $this->validate(['newComment'=>'required']);

        //creating comment
        $createdComment = Comment::create(['body'=> $this->newComment, 'user_id'=>1 ]);
        //now, to display it on the page, withou refreshing -puts it on top of comments
        // $this->comments->prepend($createdComment); //removed because of pagination

        // $this->comments->push($createdComment);        //to put the on the bottom last of the comments
      
        //bellow are old code just to display the input on the comment without db   
            // $this->comments[] = [
            //     'body' => $this->newComment,
            //     // dateandTime using Carbon
            //     'created_at' => Carbon::now()->diffForHumans(),
            //     'creator' => 'Eyu\'el N.',
            //     ];
                
          // To put this the new comment at the top use array unshift()
        //   array_unshift($this->comment, [
        //     'body' => 'Lorem  ',
        //     'created_at' => '1 mins ago',
        //     'creator' => 'Eyu\'el N.',
        //   ])

        $this->newComment = '';
        //session put for notifying
        session()->flash('message','comment added successfully');
    }

    public function remove($commentId){
        //find the comment
        $comment = Comment::find($commentId);

        //delete from db
        $comment->delete();
        //nly deletes the data from collection but not databse - this will comeback after refresh
        $this->comments = $this->comments->where('id','!=',$commentId);
        // or you can right the above as this bellow
        // $this->comments = $this->comments->except($commentId);

         //session put for notifying
        session()->flash('message','comment Deleted successfully');
    }

    public function render()
    {
        return view('livewire.comments',[
            'comments' => Comment::latest()->paginate(2)
        ]);
    }

}
