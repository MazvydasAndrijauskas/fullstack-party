<div class="form-group col-xs-12">
    <input required type="text" value="{{ isset($issue) ? $issue->title : old('title') }}" name="title"
           placeholder="Title" class="form-control"/>
</div>
<div class="form-group col-xs-12">
                                    <textarea name="body" placeholder="Leave a comment" class="form-control"
                                              rows="5">{{ isset($issue) ? $issue->body : old('body') }}
                                    </textarea>
</div>
<div class="text-right col-xs-12">
    <button type="submit" class="btn btn-success">Submit</button>
</div>
