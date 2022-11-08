<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Exlearn Courses</title>
  </head>
  <body>
    

    <div class="col-md-10 m-auto rounded py-3 card">
        @if(session('msg'))

            <div class="alert alert-success text-center">
                <p>{{session('msg')}}</p>
            </div>

        @endif
            <h4 class="card-header text-center font-weight-bold">Exlearn Courses</h4>

            <div class="text-right mt-3">
                <button data-toggle="modal" data-target="#exampleModal" class="btn btn-success text-center py-2 text-light">Create  New Course</button>
            </div>


            <div class="table-responsive mt-3">
                <table class="table table-striped">
                    <thead>
                        <th>Title</th>
                        <th>CourseCode</th>
                        <th>Type</th>
                        <th>Level</th>
                        <th>payment_type</th>
                        <th>Amount</th>
                        <th>Tutor</th>
                        <th>Image</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        @foreach($course as $courses)
                            <tr>
                                <td>{{$courses->title}}</td>
                                <td>{{$courses->coursecode}}</td>
                                <td>{{$courses->type}}</td>
                                <td>{{$courses->level}}</td>
                                <th>{{$courses->payment_type}}</th>
                                <td>{{$courses->amount}}</td>
                                <td>{{$courses->tutor}}</td>
                                <td>
                                    <img src="{{$courses->image_url}}" alt=""style="width:100px; height:100px;">
                                </td>
                                <td>
                                  <a href="{{route('coursesection',$courses->id)}}"class="btn btn-success text-center text-light">Sections</a>
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
        <h5 class="modal-title" id="exampleModalLabel">Create new Course</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <form action="{{route('createcourse')}}"method="POST">
          @csrf 

          <input type="text"name="title"class="form-control" placeholder="Enter Course Title"required> <br>

          <select name="type"class="form-control" id=""required>
              <option value="">Select Type</option>
              <option value="Frontend">Frontend</option>
              <option value="Backend">Backend</option>
              <option value="Mobile">Mobile</option>
              <option value="WordPress">WordPress</option>
              <option value="General">General</option>
          </select>
          <br>

          <select name="level"class="form-control" id=""required>
              <option value="">Select Level</option>
              <option value="Beginner">Beginner</option>
              <option value="Intermediate">Intermediate</option>
              <option value="Advance">Advance</option>
             
              <option value="General">General</option>
          </select>

          <br>
          <select name="payment_type"class="form-control" id=""required>
              <option value="">Select Payment Type</option>
              <option value="Free">Free</option>
              <option value="Paid">Paid</option>
              
          </select>

          <br>
          <input type="number"name="amount"class="form-control" placeholder="Enter Course Amount"required> <br>

          <select name="tutor"class="form-control" id=""required>
              <option value="Bobson Edidiong">Bobson Edidiong</option>
             
          </select>

          <br>

          <select name="tutor_description"class="form-control" id=""required>
              <option value="CEO Edifice Solutions , ExLearn ; Senior Software Developer">CEO Edifice Solutions , ExLearn ; Senior Software Developer</option>
             
          </select>

          <br>

          <input type="text"name="image_url"class="form-control" placeholder="Enter Course Image Url"required> <br>



          <br>

          <textarea name="course_description"class="form-control" id="" cols="10" rows="5"required></textarea> <br>
          

          <button type="submit"class="btn btn-success text-center text-light">Create Course</button>

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