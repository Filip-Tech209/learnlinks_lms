<h1>Training Course in {{ $course->title }}</h1>

<a href="{{ route('admin.courses.index') }}"><button>&larr; Back to Courses</button></a>
<a href="{{ route('admin.courses.edit', $course->id) }}"><button>Edit Course</button></a>
@if(session('success')) <p style="color: green;">{{ session('success') }}</p> @elseif ($errors->any()) <p style="color: red;">{{ $errors->first() }}</p> @endif  


<form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
    @csrf @method('DELETE')
    <button type="submit" style="color: red;">Delete Course</button>
</form> <br>

{{-- course picture --}}
<img src="{{ asset('storage/' . $course->featured_image) }}" alt="{{ $course->title }}" style="max-width: 10%; height: auto;">

<hr>
<h1>Tab 1: Core Overview</h1>
<ul>
    <li><strong>Category:</strong> {{ $course->category->name ?? 'N/A' }}</li>
    <li><strong>Name:</strong> {{ $course->title ?? 'N/A' }}</li>
    <li><strong>Description:</strong> {{ $course->description }}</li>
    <li><strong>Duration:</strong> {{ $course->duration }} | <strong>Delivery:</strong> {{ $course->delivery_method }}</li>
    <li><strong>Price:</strong> ${{ number_format($course->base_price, 2) }}</li>
</ul>

<h2>Course Objectives</h2>

@if($course->meta && $course->meta->objectives)
    @php
        $objectives = preg_split('/\.\s+/', trim($course->meta->objectives));
    @endphp

    <ul class="course-objectives">
        @foreach($objectives as $objective)
            @if(!empty(trim($objective)))
                <li>{{ rtrim($objective, '.') }}.</li>
            @endif
        @endforeach
    </ul>
@endif

<h2>Organisational Impact</h2>

@if($course->meta && $course->meta->organizational_impacts)
    @php
        // Split into sentences ending with a period followed by whitespace or end of string
        $impacts = preg_split('/\.\s*/', trim($course->meta->organizational_impacts));
    @endphp

    <ul class="organizational-impacts">
        @foreach($impacts as $impact)
            @php
                $impact = trim($impact);

                if ($impact === '') {
                    continue;
                }

                // Match both en dash (–) and normal hyphen (-)
                if (preg_match('/^(.+?)\s*[–-]\s*(.+)$/u', $impact, $matches)) {
                    $title = trim($matches[1]);
                    $description = trim($matches[2]);
                } else {
                    $title = null;
                    $description = $impact;
                }
            @endphp

            <li>
                @if($title)
                    <strong>{{ $title }}</strong> – {{ $description }}.
                @else
                    {{ $description }}.
                @endif
            </li>
        @endforeach
    </ul>
@endif

<h2>Personal Impact</h2>
@if($course->meta && $course->meta->personal_impacts)
    @php
        // Split into sentences ending with a period followed by whitespace or end of string
        $personalImpacts = preg_split('/\.\s*/', trim($course->meta->personal_impacts));
    @endphp
    <ul class="personal-impacts">
        @foreach($personalImpacts as $impact)
            @php
                $impact = trim($impact);

                if ($impact === '') {
                    continue;
                }

                // Match both en dash (–) and normal hyphen (-)
                if (preg_match('/^(.+?)\s*[–-]\s*(.+)$/u', $impact, $matches)) {
                    $title = trim($matches[1]);
                    $description = trim($matches[2]);
                } else {
                    $title = null;
                    $description = $impact;
                }
            @endphp

            <li>
                @if($title)
                    <strong>{{ $title }}</strong> – {{ $description }}.
                @else
                    {{ $description }}.
                @endif
            </li>
        @endforeach
    </ul>
@endif

<h1>Tab2:Couse Outline</h1>
<h2>Course Modules</h2>

@if($course->modules->count())
    <div class="course-modules">

        @foreach($course->modules as $module)
            @php
                // Split module content into individual statements.
                // Handles periods, line breaks, or both.
                $points = preg_split('/(?:\.\s*|\r\n|\r|\n)+/', trim($module->content));
            @endphp

            <div class="module-item">
                <strong class="module-title">
                    @if(Str::startsWith(strtolower($module->title), 'module'))
                        {{ $module->title }}
                    @else
                        Module {{ $loop->iteration }}: {{ $module->title }}
                    @endif
                </strong>

                @if(count(array_filter($points)))
                    <ul class="module-points">
                        @foreach($points as $point)
                            @php $point = trim($point); @endphp

                            @if($point !== '')
                                <li>{{ rtrim($point, '.') }}.</li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach

    </div>
@endif
<p><strong>Note:</strong> The specific content, activities, and duration of each session may be adjusted based on the target audience, learning objectives, and available time.</p>

<h1>Tab 3: More Course Information</h1>
<div class="more-course-info">
    <p><strong>Course Language:</strong> {{ $course->meta->language ?? 'English' }}</p>

    {{-- NEW: Dynamic Requirements Display --}}
    @if($course->meta && $course->meta->requirements)
        <h3>Prerequisites & Requirements</h3>
        <p>{{ $course->meta->requirements }}</p>
    @endif

    <h3>Training Methodology</h3>
    @if($course->meta && $course->meta->training_methodology)
        @php
            $content = trim($course->meta->training_methodology);
            $parts = preg_split('/:\s*/', $content, 2);
            $intro = $parts[0] ?? '';
            $listContent = $parts[1] ?? '';
            $methods = preg_split('/\.\s*/', trim($listContent));
        @endphp

        @if($intro)
            <p class="training-intro">
                {{ $intro }}:
            </p>
        @endif

        <ul class="training-methodology">
            @foreach($methods as $method)
                @php
                    $method = trim($method);
                    if ($method === '') continue;
                    
                    if (preg_match('/^(.+?)\s*[–-]\s*(.+)$/u', $method, $matches)) {
                        $title = trim($matches[1]);
                        $description = trim($matches[2]);
                    } else {
                        $title = null;
                        $description = $method;
                    }
                @endphp
                <li>
                    @if($title)
                        <strong>{{ $title }}</strong> – {{ $description }}.
                    @else
                        {{ $description }}.
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

    {{-- NEW: Dynamic Certification Details with a clean fallback --}}
    <h3>Certification</h3>
    @if($course->meta && $course->meta->certification_details)
        <p>{{ $course->meta->certification_details }}</p>
    @else
        <p>Upon completion of training, the participant will be issued with a certificate of Completion.</p>
    @endif
</div>

<h1>Fixed column left</h1>

<h3>Download Brochure</h3>
@if($course->meta && $course->meta->brochure_path)
    <a href="{{ asset('storage/' . $course->meta->brochure_path) }}" target="_blank" class="btn btn-outline-primary">
        Download Brochure (PDF)
    </a>
@else
    <h3>Download Brochure</h3>
    <p class="text-muted">No brochure available for this course.</p>
@endif

<h3>Training Schedules</h3>
@php
    $classroomSchedules = $course->schedules->filter(function ($schedule) {
        return strtolower($schedule->delivery_mode) === 'classroom';
    });

    $onlineSchedules = $course->schedules->filter(function ($schedule) {
        return strtolower($schedule->delivery_mode) === 'online';
    });
@endphp

{{-- Classroom Schedule --}}
@if($classroomSchedules->count())
    <h4>Classroom Training</h4>

    <div class="table-responsive mb-4">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Duration</th>
                    <th>Location</th>
                    <th>Cost (USD)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classroomSchedules as $schedule)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($schedule->start_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->end_date)->format('d M Y') }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($schedule->start_date)->diffInDays(\Carbon\Carbon::parse($schedule->end_date)) + 1 }}
                            Days
                        </td>
                        <td>{{$schedule->delivery_mode}}</td>
                        <td>${{ number_format($schedule->cost, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif


{{-- Online Schedule --}}
@if($onlineSchedules->count())
    <h4>Virtual Training</h4>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Duration</th>
                    <th>Location</th>
                    <th>Cost (USD)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($onlineSchedules as $schedule)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($schedule->start_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->end_date)->format('d M Y') }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($schedule->start_date)->diffInDays(\Carbon\Carbon::parse($schedule->end_date)) + 1 }}
                            Days
                        </td>
                         <td>{{$schedule->delivery_mode}}</td>
                        <td>${{ number_format($schedule->cost, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p>No Schedules Available</p>
@endif

<h3>Tailor Made Course</h3>
<p>Tailor-Made Course
If you prefer email training materials, consultation, and coaching in a guaranteed time and place, then you can reach, Do you have 4+ people? We can plan on-site, in a 1 day, 2 days or more session format. Contact us to find out more: training@perk-gafrica.com</p>
<button><a href="#">View All Courses</a></button>


<div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
    <h3>Frequently Asked Questions</h3>
    
    @if($course->faqs && $course->faqs->isNotEmpty())
        <div style="display: flex; flex-direction: column; gap: 10px;">
            @foreach($course->faqs as $faq)
                <details style="background: #f9f9f9; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px; cursor: pointer;">
                    <summary style="font-weight: bold; font-size: 1.1em; color: #2d3748; outline: none; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                        <span>Q: {{ $faq->question }}</span>
                        <span style="font-size: 0.8em; color: #718096;">▼</span>
                    </summary>
                    <p style="margin: 10px 0 0 0; padding-top: 10px; border-top: 1px solid #edf2f7; color: #4a5568; line-height: 1.6; cursor: default;">
                        {{ $faq->answer }}
                    </p>
                </details>
            @endforeach
        </div>
    @else
        <p style="color: #718096; font-style: italic;">No FAQs have been added to this course yet.</p>
    @endif
</div>
