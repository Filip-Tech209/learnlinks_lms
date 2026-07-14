<h1>All Courses</h1>
<a href="{{ route('dashboard') }}"><button>&larr; Back to Dashboard</button></a>
<hr>

@if(session('success')) <p style="color: green;">{{ session('success') }}</p> @elseif ($errors->any()) <p style="color: red;">{{ $errors->first() }}</p> @endif  


<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Image</th>
        <th>Title</th>
        <th>Duration</th>
        <th>Delivery Method</th>
        <th>Base Price</th>
        <th>Actions</th>
    </tr>
    @foreach($courses as $course)
    <tr>
        <td>{{ $course->featured_image ? 'Image Present' : 'No Image' }}</td>
        <td>{{ $course->title }}</td>
        <td>{{ $course->duration }}</td>
        <td>{{ ucfirst($course->delivery_method) }}</td>
        <td>${{ number_format($course->base_price, 2) }}</td>
        <td>
            <a href="{{ route('admin.courses.show', $course->id) }}"><button>View More Details</button></a>
        </td>
    </tr>
    @endforeach
</table>