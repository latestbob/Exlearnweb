<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Exlearn Sections</title>
  </head>
  <body>
    

    <div class="col-md-10 m-auto rounded py-3 card">
        @if(session('msg'))

            <div class="alert alert-success text-center">
                <p>{{session('msg')}}</p>
            </div>

        @endif
            <h4 class="card-header text-center font-weight-bold">{{$course->title}}</h4>

            <div class="text-right mt-3">
                <button data-toggle="modal" data-target="#exampleModal" class="btn btn-success text-center py-2 text-light">Create  New Section</button>
            </div>


            <div class="table-responsive mt-3">
                <table class="table table-striped">
                    <thead>
                        <th>Title</th>
                        <th>CourseCode</th>
                        <th>Section_Code</th>
                        <th>Total Minutes</th>
                        <th>Actions</th>
                       
                    </thead>

                    <tbody>

                    @foreach($sections as $section)

                      <tr>
                        <td>{{$section->title}}</td>
                        <td>{{$section->coursecode}}</td>
                        <td>{{$section->section_code}}</td>
                        <td></td>
                        <td>
                          <a href="{{route('sectionlessons',$section->id)}}"class="btn btn-success text-center text-light">Lessons</a>
                        </td>
                      </tr>
                    @endforeach
                        
                    </tbody>
                </table>
            </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create new Section</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <form action="{{route('sectioncreate')}}"method="POST">
          @csrf 

          <input type="hidden"name="coursecode"value="{{$course->coursecode}}"required>

          <input type="text"name="title"class="form-control" placeholder="Enter Section Title"required> <br>

         
         

        

        



          <br>

          

          <button type="submit"class="btn btn-success text-center text-light">Create Section</button>

          <br>

      </form>

      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

 
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
  </body>
</html>