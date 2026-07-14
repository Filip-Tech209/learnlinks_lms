<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<h1>Add New Course</h1>
<a href="{{ route('dashboard') }}"><button>&larr; Back to Dashboard</button></a>
<hr>
@if(session('success')) <p style="color: green;">{{ session('success') }}</p> @elseif ($errors->any()) <p style="color: red;">{{ $errors->first() }}</p> @endif  


<form action="{{ route('admin.courses.store') }}" 
      method="POST" 
      enctype="multipart/form-data" 
      x-data="courseForm([], [], [])">
    @csrf
    <h3>1. Core Details</h3>
    <input type="text" name="title" placeholder="Title" required>
    <select name="category_id" required>
        <option value="">Select Category</option>
        @foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
    </select>
    <textarea name="description" placeholder="Description"></textarea>
    <input type="text" name="delivery_method" placeholder="Delivery (e.g. Hybrid)" required>
    <input type="text" name="duration" placeholder="Duration (e.g. 5 Days)" required>
    <input type="number" name="base_price" placeholder="Base Price">
    <input type="file" name="featured_image" placeholder="featured image">

    <h3>2. Meta Data(Objectives/Impacts)</h3>
    <textarea name="meta[objectives]" placeholder="Course Objectives"></textarea>
    <input type="text" name="meta[language]" value="English">
    <textarea name="meta[organizational_impacts]" placeholder="Organizational Impacts"></textarea>
    <textarea name="meta[personal_impacts]" placeholder="Personal Impacts"></textarea>
    <textarea name="meta[certification_details]" placeholder="Certification Details"></textarea>
    <textarea name="meta[training_methodology]" placeholder="Training Methodology"></textarea>
    <textarea name="meta[requirements]" placeholder="Prerequisites / Requirements"></textarea>

    <!-- File Upload for Brochure -->
    <label for="brochure">Course Brochure (PDF):</label>
    <input type="file" name="brochure" id="brochure" accept=".pdf">

    <h3>3. Modules</h3>
    <template x-for="(module, index) in modules" :key="index">
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:5px;">
            <!-- Dynamic Header showing auto-incrementing prefix -->
            <h4 x-text="'Module ' + (index + 1) + ': ' + (module.title || 'Untitled Module')"></h4>
            
            <!-- Bound Title Input -->
            <input type="text" 
                :name="`modules[${index}][title]`" 
                x-model="module.title" 
                placeholder="Module Title" 
                required>
                
            <!-- Auto-filled order field for database sorting -->
            <input type="hidden" :name="`modules[${index}][order]`" :value="index + 1">

            <textarea :name="`modules[${index}][content]`" placeholder="Content"></textarea>
            
            <button type="button" @click="modules.splice(index, 1)">Remove Module</button>
        </div>
    </template>
    <button type="button" @click="modules.push({ title: '', content: '' })">+ Add Module</button>

    <h3>4. Schedules</h3>
    <template x-for="(schedule, index) in schedules" :key="index">
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:5px;">
            <select :name="`schedules[${index}][delivery_mode]`">
                <option value="online">Online</option>
                <option value="classroom">Classroom</option>
            </select>
            <input type="date" :name="`schedules[${index}][start_date]`">
            <input type="date" :name="`schedules[${index}][end_date]`">
            <input type="number" :name="`schedules[${index}][cost]`" placeholder="Cost">
            <button type="button" @click="schedules.splice(index, 1)">Remove Schedule</button>
        </div>
    </template>
<button type="button" @click="schedules.push({ delivery_mode: 'online', start_date: '', end_date: '', cost: '' })">+ Add Schedule</button>

    <br><br>
    <button type="submit" style="padding: 10px 20px; background: green; color: white;">Save Entire Course</button>
</form>

<script>
    
    function courseForm() {
        return {
            // Initialize with an empty string so the model is ready to watch
            modules: [{ title: '', content: '' }], 
            schedules: [{ delivery_mode: 'online' }]
        }
    }
</script>