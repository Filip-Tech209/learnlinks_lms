<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@include('layouts.instructor_style')

<div class="container">
    <div class="header-section">
        <h1>Edit Instructor Profile ({{ $instructor->instructor_number }})</h1>
        <a href="{{ route('instructors.index') }}" class="btn btn-back">&larr; Back to Registry</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" style="background: var(--danger-bg); color: var(--danger); padding: 1rem; border-radius: 8px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('instructors.update', $instructor->id) }}" method="POST" x-data="instructorEditForm()">
        @csrf
        @method('PUT')

        <h3>1. Core Account Details</h3>
        <div class="grid-2">
            <div class="form-group">
                <label>First Name <span style="color: red;">*</span></label>
                <input type="text" name="instructor[first_name]" value="{{ old('instructor.first_name', $instructor->first_name) }}" required>
            </div>
            <div class="form-group">
                <label>Last Name <span style="color: red;">*</span></label>
                <input type="text" name="instructor[last_name]" value="{{ old('instructor.last_name', $instructor->last_name) }}" required>
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label>Email Address <span style="color: red;">*</span></label>
                <input type="email" name="instructor[email]" value="{{ old('instructor.email', $instructor->email) }}" required>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="instructor[phone]" value="{{ old('instructor.phone', $instructor->phone) }}">
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label>Hire Date <span style="color: red;">*</span></label>
                <input type="date" name="instructor[hire_date]" value="{{ old('instructor.hire_date', $instructor->hire_date) }}" required>
            </div>
            <div class="form-group">
                <label>Account Status <span style="color: red;">*</span></label>
                <select name="instructor[status]" required>
                    <option value="active" {{ $instructor->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $instructor->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="suspended" {{ $instructor->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
        </div>

        <h3>2. Deep-Dive Profile Details</h3>
        <div class="grid-3">
            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="detail[date_of_birth]" value="{{ old('detail.date_of_birth', $instructor->detail->date_of_birth ?? '') }}">
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="detail[gender]">
                    <option value="">Select Gender</option>
                    <option value="male" {{ ($instructor->detail->gender ?? '') === 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ ($instructor->detail->gender ?? '') === 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ ($instructor->detail->gender ?? '') === 'other' ? 'selected' : '' }}>Other</option>
                    <option value="prefer_not_to_say" {{ ($instructor->detail->gender ?? '') === 'prefer_not_to_say' ? 'selected' : '' }}>Prefer Not to Say</option>
                </select>
            </div>
            <div class="form-group">
                <label>Core Technical Specialty</label>
                <input type="text" name="detail[specialty]" value="{{ old('detail.specialty', $instructor->detail->specialty ?? '') }}" placeholder="e.g. Laravel Core, Flutter Architecture">
            </div>
        </div>

        <div class="form-group">
            <label>Physical Address</label>
            <input type="text" name="detail[address]" value="{{ old('detail.address', $instructor->detail->address ?? '') }}">
        </div>

        <div class="form-group">
            <label>Professional Biography</label>
            <textarea name="detail[bio]" rows="3">{{ old('detail.bio', $instructor->detail->bio ?? '') }}</textarea>
        </div>

        <h3>3. Dynamic Certifications</h3>
        <template x-for="(cert, index) in certifications" :key="index">
            <div class="dynamic-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h4 x-text="'Certification #' + (index + 1)" style="margin: 0; font-size: 0.95rem; color: #475569;"></h4>
                    <button type="button" class="btn btn-danger" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;" @click="removeCert(index)">Remove</button>
                </div>

                <!-- Hidden ID Tracker for Database Matching (Protects against clone query builder trap) -->
                <input type="hidden" :name="`certifications[${index}][id]`" x-model="cert.id">

                <div class="grid-3">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Certification Name</label>
                        <input type="text" :name="`certifications[${index}][name]`" x-model="cert.name" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Issuing Authority</label>
                        <input type="text" :name="`certifications[${index}][issuing_authority]`" x-model="cert.issuing_authority" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Attained Date</label>
                        <input type="date" :name="`certifications[${index}][attained_date]`" x-model="cert.attained_date" required>
                    </div>
                </div>
            </div>
        </template>

        <button type="button" class="btn btn-outline" @click="addCert()">+ Add Professional Certification</button>

        <hr style="border: none; border-top: 1px solid var(--border-color); margin: 2rem 0;">

        <div style="display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-success" style="font-size: 1rem; padding: 0.75rem 2rem;">Apply Updates</button>
        </div>
    </form>
</div>

<script>
    function instructorEditForm() {
        return {
            // Load existing records securely into the Alpine state
            certifications: {!! json_encode($instructor->certifications) !!},
            addCert() {
                this.certifications.push({ id: null, name: '', issuing_authority: '', attained_date: '' });
            },
            removeCert(index) {
                this.certifications.splice(index, 1);
            }
        }
    }
</script>