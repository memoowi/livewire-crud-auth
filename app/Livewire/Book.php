<?php

namespace App\Livewire;

use App\Models\Book as ModelsBook;
use Livewire\Component;
use Livewire\WithPagination;

class Book extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $title;
    public $author;
    public $year;
    public $editMode = false;
    public $book_id;
    public $search;
    public $selected = [];
    public $sortColumn = 'title';
    public $sortDirection = 'asc';
    public function sort($column)
    {
        $this->sortColumn = $column;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
    }
    public function render()
    {
        if($this->search != null){
            $data = ModelsBook::where('title','like','%'.$this->search.'%')
            ->orWhere('author','like','%'.$this->search.'%')
            ->orWhere('year','like','%'.$this->search.'%')
            ->orderBy($this->sortColumn,$this->sortDirection)->paginate(3);
        }else{
            $data = ModelsBook::orderBy($this->sortColumn,$this->sortDirection)->paginate(3);
        }
        return view('livewire.book', ['books'=>$data]);
    }
    public function store()
    {
        $rules = [
            'title'=> 'required',
            'author'=> 'required',
            'year'=> 'required|min:4',
            ];
        $message = [
            'title.required'=> 'Title field cant be empty',
            'author.required'=> 'Author field cant be empty',
            'year.required'=> 'Year field cant be empty',
            'year.min'=> 'Year cant be less than 4 number',
        ];
        $validated = $this->validate($rules, $message);
        ModelsBook::create($validated);
        session()->flash('success','Data created successfully');
        $this->clear();
    }
    public function edit($id)
    {
        $data = ModelsBook::find($id);
        $this->title = $data->title;
        $this->author = $data->author;
        $this->year = $data->year;

        $this->editMode = true;
        $this->book_id = $id;
    }
    public function update()
    {
        $rules = [
            'title'=> 'required',
            'author'=> 'required',
            'year'=> 'required|min:4',
            ];
        $message = [
            'title.required'=> 'Title field cant be empty',
            'author.required'=> 'Author field cant be empty',
            'year.required'=> 'Year field cant be empty',
            'year.min'=> 'Year cant be less than 4 number',
        ];
        $validated = $this->validate($rules, $message);
        $data = ModelsBook::find($this->book_id);
        $data->update($validated);
        session()->flash('success','Data Updated successfully');

        $this->clear();
    }
    public function clear()
    {
        $this->title = '';
        $this->author = '';
        $this->year = '';

        $this->editMode = false;
        $this->book_id = '';
        $this->selected = [];
    }
    public function delete()
    {
        if($this->book_id != ''){
            $id = $this->book_id;
            ModelsBook::find($id)->delete();
        }
        if(count($this->selected)){
            for($x = 0; $x <count($this->selected); $x++)
            {
                ModelsBook::find($this->selected[$x])->delete();
            }
        }
        session()->flash('success','Data Deleted');
        $this->clear();
    }
    public function deleteConfirmation($id)
    {
        if($id != ''){
            $this->book_id = $id;
        }
    }
}
