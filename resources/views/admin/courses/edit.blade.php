<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<h1>Edit Course: {{ $course->title }}</h1>
<a href="{{ route('admin.courses.show', $course->id) }}"><button>&larr; Back to Details</button></a>
<hr>

@if(session('success')) 
    <p style="color: green;">{{ session('success') }}</p> 
@elseif ($errors->any()) 
    <p style="color: red;">{{ $errors->first() }}</p> 
@endif  

{{-- 1. SAFE DATA BRIDGE: Load Laravel collections to window variables to prevent Quote Collisions --}}
<script>
    window.__courseModules = @json($course->modules ?? []);
    window.__courseSchedules = @json($course->schedules ?? []);
    window.__courseFaqs = @json($course->faqs ?? []);
</script>

<!-- UPDATE this line to accept window.__courseFaqs -->
<form action="{{ route('admin.courses.update', $course->id) }}" 
      method="POST" 
      enctype="multipart/form-data" 
      x-data="courseForm(window.__courseModules, window.__courseSchedules, window.__courseFaqs)">
    @csrf 
    @method('PUT')
    
    <h3>1. Core Details</h3>
    <label>Course Title:</label>
    <input type="text" name="title" value="{{ old('title', $course->title) }}" required style="width: 100%; margin-bottom: 10px;">
    
    <label>Category:</label>
    <select name="category_id" required style="width: 100%; margin-bottom: 10px;">
        @foreach($categories as $cat) 
            <option value="{{ $cat->id }}" {{ old('category_id', $course->category_id) == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option> 
        @endforeach
    </select>
    
    <label>Description:</label>
    <textarea name="description" style="width: 100%; height: 100px; margin-bottom: 10px;">{{ old('description', $course->description) }}</textarea>
    
    <div style="display: flex; gap: 15px; margin-bottom: 10px;">
        <div style="flex: 1;">
            <label>Delivery Method:</label>
            <input type="text" name="delivery_method" value="{{ old('delivery_method', $course->delivery_method) }}" required style="width: 100%;">
        </div>
        <div style="flex: 1;">
            <label>Duration:</label>
            <input type="text" name="duration" value="{{ old('duration', $course->duration) }}" required style="width: 100%;">
        </div>
        <div style="flex: 1;">
            <label>Base Price ($):</label>
            <input type="number" name="base_price" value="{{ old('base_price', $course->base_price) }}" style="width: 100%;">
        </div>
    </div>

    {{-- Course Image Section --}}
    <div style="border: 1px solid #ddd; padding: 15px; margin: 15px 0; background: #fafafa;">
        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Course Cover Image:</label>
        
        {{-- Show image if image_path exists in database --}}
        @if($course->featured_image)
            <div style="margin-bottom: 10px;">
                <p style="margin: 0 0 5px 0; font-size: 0.9em; font-weight: bold; color: #555;">Current Image:</p>
                <img src="{{ asset('storage/' . $course->featured_image) }}" alt="Course Cover Image" style="max-height: 120px; border-radius: 4px; border: 1px solid #ccc; display: block;">
            </div>
        @endif
        
        <input type="file" name="image" id="image" accept="image/*">
        <small style="display:block; color: #666; margin-top: 5px;">Upload a cover image for the course listings page (JPEG, PNG, WebP).</small>
    </div>

    <h3>2. Meta Data (Objectives/Impacts)</h3>
    <label>Objectives:</label>
    <textarea name="meta[objectives]" placeholder="Paste objectives..." style="width: 100%; height: 100px; margin-bottom: 10px;">{{ old('meta.objectives', $course->meta->objectives ?? '') }}</textarea>
    
    <label>Language:</label>
    <input type="text" name="meta[language]" value="{{ old('meta.language', $course->meta->language ?? 'English') }}" style="width: 100%; margin-bottom: 10px;">
    
    <label>Organizational Impacts:</label>
    <textarea name="meta[organizational_impacts]" placeholder="Paste organizational impacts..." style="width: 100%; height: 100px; margin-bottom: 10px;">{{ old('meta.organizational_impacts', $course->meta->organizational_impacts ?? '') }}</textarea>
    
    <label>Personal Impacts:</label>
    <textarea name="meta[personal_impacts]" placeholder="Paste personal impacts..." style="width: 100%; height: 100px; margin-bottom: 10px;">{{ old('meta.personal_impacts', $course->meta->personal_impacts ?? '') }}</textarea>
    
    <label>Certification Details:</label>
    <textarea name="meta[certification_details]" placeholder="Upon completion of training, the participant..." style="width: 100%; height: 80px; margin-bottom: 10px;">{{ old('meta.certification_details', $course->meta->certification_details ?? '') }}</textarea>
    
    <label>Training Methodology:</label>
    <textarea name="meta[training_methodology]" placeholder="How the course is delivered..." style="width: 100%; height: 100px; margin-bottom: 10px;">{{ old('meta.training_methodology', $course->meta->training_methodology ?? '') }}</textarea>
    
    <label>Prerequisites / Requirements:</label>
    <textarea name="meta[requirements]" placeholder="Any prior experience or environment setup required..." style="width: 100%; height: 80px; margin-bottom: 10px;">{{ old('meta.requirements', $course->meta->requirements ?? '') }}</textarea>

    {{-- Course Brochure Section --}}
    <div style="border: 1px solid #ddd; padding: 15px; margin: 15px 0; background: #fafafa;">
        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Course Brochure (PDF):</label>
        @if($course->meta && $course->meta->brochure_path)
            <p style="margin: 0 0 10px 0; font-size: 0.9em; color: green;">
                ✓ Existing Brochure uploaded: 
                <a href="{{ asset('storage/' . $course->meta->brochure_path) }}" target="_blank" style="text-decoration: underline;">
                    Download / View Brochure
                </a>
            </p>
        @else
            <p style="margin: 0 0 10px 0; font-size: 0.9em; color: #999;">No brochure uploaded yet.</p>
        @endif
        <input type="file" name="brochure" id="brochure" accept=".pdf">
        <small style="display:block; color: #666; margin-top: 5px;">Uploading a new PDF replaces the existing brochure automatically.</small>
    </div>

    <h3>3. Modules</h3>
    <template x-for="(module, index) in modules" :key="index">
        <div style="border:1px solid #ccc; padding:15px; margin-bottom:10px; background: #fff; position: relative;">
            {{-- ONE-WAY BINDING FOR ID TO PREVENT ALPINE ISSUES --}}
            <input type="hidden" :name="'modules[' + index + '][id]'" :value="module.id ?? ''">
            
            <input type="hidden" :name="'modules[' + index + '][order]'" :value="index + 1">

            <h4 x-text="'Module ' + (index + 1) + ': ' + (module.title || 'Untitled Module')" style="margin-top: 0;"></h4>
            
            <div style="margin-bottom: 10px;">
                <label style="display: block; font-size: 0.9em; font-weight: bold;">Module Title:</label>
                <input type="text" 
                       :name="'modules[' + index + '][title]'" 
                       x-model="module.title" 
                       placeholder="e.g. Introduction to Project Management"
                       required 
                       style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-size: 0.9em; font-weight: bold;">Module Content (One point per line):</label>
                <textarea :name="'modules[' + index + '][content]'" 
                          x-model="module.content" 
                          placeholder="e.g. Understanding key terminology.&#10;Defining scope of work."
                          style="width: 100%; height: 80px;"></textarea>
            </div>
            
            <button type="button" 
                    @click="modules.splice(index, 1)" 
                    style="margin-top: 10px; color: white; background: #dc3545; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px;">
                Remove Module
            </button>
        </div>
    </template>
    <button type="button" @click="modules.push({ id: null, title: '', content: '' })" style="padding: 5px 15px; background: #f0f0f0; border: 1px solid #ccc; cursor: pointer;">
        + Add Module
    </button>

    <h3>4. Schedules</h3>
    <template x-for="(schedule, index) in schedules" :key="index">
        <div style="border:1px solid #ccc; padding:15px; margin-bottom:10px; background: #fff;">
            {{-- ONE-WAY BINDING FOR ID TO PREVENT ALPINE ISSUES --}}
            <input type="hidden" :name="'schedules[' + index + '][id]'" :value="schedule.id ?? ''">
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; align-items: end;">
                <div>
                    <label style="display: block; font-size: 0.9em; font-weight: bold;">Mode:</label>
                    <select :name="'schedules[' + index + '][delivery_mode]'" x-model="schedule.delivery_mode" style="width: 100%; height: 35px;">
                        <option value="online">Online</option>
                        <option value="classroom">Classroom</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 0.9em; font-weight: bold;">Start Date:</label>
                    <input type="date" :name="'schedules[' + index + '][start_date]'" x-model="schedule.start_date" style="width: 100%; height: 35px;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 0.9em; font-weight: bold;">End Date:</label>
                    <input type="date" :name="'schedules[' + index + '][end_date]'" x-model="schedule.end_date" style="width: 100%; height: 35px;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 0.9em; font-weight: bold;">Cost ($):</label>
                    <input type="number" :name="'schedules[' + index + '][cost]'" x-model="schedule.cost" placeholder="Cost" style="width: 100%; height: 31px;">
                </div>
            </div>
            
            <button type="button" 
                    @click="schedules.splice(index, 1)" 
                    style="margin-top: 10px; color: white; background: #dc3545; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px;">
                Remove Schedule
            </button>
        </div>
    </template>
    <button type="button" @click="schedules.push({ id: null, delivery_mode: 'online', start_date: '', end_date: '', cost: '' })" style="padding: 5px 15px; background: #f0f0f0; border: 1px solid #ccc; cursor: pointer;">
        + Add Schedule
    </button>

    <br><br>
    <h3>5. Frequently Asked Questions (FAQs)</h3>
    <template x-for="(faq, index) in faqs" :key="index">
        <div style="border:1px solid #ccc; padding:15px; margin-bottom:10px; background: #fff;">
            {{-- Safe ID binding --}}
            <input type="hidden" :name="'faqs[' + index + '][id]'" :value="faq.id ?? ''">
            
            <div style="margin-bottom: 10px;">
                <label style="display: block; font-size: 0.9em; font-weight: bold;">Question:</label>
                <input type="text" 
                       :name="'faqs[' + index + '][question]'" 
                       x-model="faq.question" 
                       placeholder="e.g. What are the prerequisites for this course?"
                       required 
                       style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-size: 0.9em; font-weight: bold;">Answer:</label>
                <textarea :name="'faqs[' + index + '][answer]'" 
                          x-model="faq.answer" 
                          placeholder="Provide a clear, detailed answer here..."
                          required
                          style="width: 100%; height: 80px;"></textarea>
            </div>
            
            <button type="button" 
                    @click="faqs.splice(index, 1)" 
                    style="margin-top: 10px; color: white; background: #dc3545; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px;">
                Remove FAQ
            </button>
        </div>
    </template>
    <button type="button" @click="faqs.push({ id: null, question: '', answer: '' })" style="padding: 5px 15px; background: #f0f0f0; border: 1px solid #ccc; cursor: pointer;">
        + Add FAQ
    </button>


    <br><br>
    <button type="submit" style="padding: 12px 25px; background: #0d6efd; color: white; font-weight: bold; border: none; cursor: pointer; border-radius: 4px;">
        Update Course
    </button>
</form>

<script>
    function courseForm(initialModules, initialSchedules, initialFaqs) { // <-- Added parameter
        const modulesList = Array.isArray(initialModules) ? initialModules : [];
        const schedulesList = Array.isArray(initialSchedules) ? initialSchedules : [];
        const faqsList = Array.isArray(initialFaqs) ? initialFaqs : []; // <-- INJECT THIS

        return {
            modules: modulesList.length 
                ? modulesList.map(m => ({
                    id: m.id || null,
                    title: m.title || '',
                    content: m.content || '',
                    order: m.order || ''
                  }))
                : [{ id: null, title: '', content: '' }],
            
            schedules: schedulesList.length 
                ? schedulesList.map(s => ({
                    id: s.id || null,
                    delivery_mode: s.delivery_mode || 'online',
                    start_date: s.start_date ? s.start_date.substring(0, 10) : '',
                    end_date: s.end_date ? s.end_date.substring(0, 10) : '',
                    cost: s.cost || ''
                  }))
                : [{ id: null, delivery_mode: 'online', start_date: '', end_date: '', cost: '' }],

            // INJECT THIS FAQS MAPPER
            faqs: faqsList.length 
                ? faqsList.map(f => ({
                    id: f.id || null,
                    question: f.question || '',
                    answer: f.answer || ''
                  }))
                : [{ id: null, question: '', answer: '' }]
        }
    }
</script>