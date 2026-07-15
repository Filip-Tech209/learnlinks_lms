<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@include('layouts.instructor_style')

<div class="container">
    <div class="header-section">
        <h1>Add New Instructor</h1>
        <a href="{{ route('instructors.index') }}" class="btn btn-back">&larr; Back to Registry</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" style="background: var(--danger-bg); color: var(--danger); padding: 1rem; border-radius: 8px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('instructors.store') }}" method="POST" x-data="instructorForm()">
        @csrf

        <h3>1. Core Account Details</h3>
        <div class="grid-2">
            <div class="form-group">
                <label>First Name <span style="color: red;">*</span></label>
                <input type="text" name="instructor[first_name]" placeholder="e.g. John" required>
            </div>
            <div class="form-group">
                <label>Last Name <span style="color: red;">*</span></label>
                <input type="text" name="instructor[last_name]" placeholder="e.g. Doe" required>
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label>Email Address <span style="color: red;">*</span></label>
                <input type="email" name="instructor[email]" placeholder="e.g. john.doe@school.com" required>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="instructor[phone]" placeholder="e.g. +254 700 000000">
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label>Hire Date <span style="color: red;">*</span></label>
                <input type="date" name="instructor[hire_date]" required>
            </div>
            <div class="form-group">
                <label>Account Status <span style="color: red;">*</span></label>
                <select name="instructor[status]" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="suspended">Suspended</option>
                </select>
            </div>
        </div>

        <h3>2. Deep-Dive Profile Details</h3>
        <div class="grid-3">
            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="detail[date_of_birth]">
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="detail[gender]">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                    <option value="prefer_not_to_say">Prefer Not to Say</option>
                </select>
            </div>
            <div class="form-group">
                <label>Core Technical Specialty</label>
                <input type="text" name="detail[specialty]" placeholder="e.g. Laravel Core, Flutter Architecture">
            </div>
        </div>

        <div class="form-group">
            <label>Physical Address</label>
            <input type="text" name="detail[address]" placeholder="e.g. 123 School Lane, Westlands">
        </div>

        <div class="form-group">
            <label>Professional Biography</label>
            <textarea name="detail[bio]" rows="3" placeholder="Brief statement regarding expertise and track record..."></textarea>
        </div>

        <h3>3. Dynamic Certifications</h3>
        <template x-for="(cert, index) in certifications" :key="index">
            <div class="dynamic-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h4 x-text="'Certification #' + (index + 1)" style="margin: 0; font-size: 0.95rem; color: #475569;"></h4>
                    <button type="button" class="btn btn-danger" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;" @click="removeCert(index)">Remove</button>
                </div>

                <div class="grid-3">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Certification Name</label>
                        <input type="text" :name="`certifications[${index}][name]`" x-model="cert.name" placeholder="e.g. AWS Architect">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Issuing Authority</label>
                        <input type="text" :name="`certifications[${index}][issuing_authority]`" x-model="cert.issuing_authority" placeholder="e.g. Amazon">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Attained Date</label>
                        <input type="date" :name="`certifications[${index}][attained_date]`" x-model="cert.attained_date">
                    </div>
                </div>
            </div>
        </template>

        <button type="button" class="btn btn-outline" @click="addCert()">+ Add Professional Certification</button>

        <hr style="border: none; border-top: 1px solid var(--border-color); margin: 2rem 0;">

        <div style="display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-success" style="font-size: 1rem; padding: 0.75rem 2rem;">Save Instructor Profile</button>
        </div>
    </form>
</div>

<script>
    function instructorForm() {
        return {
            certifications: [],
            addCert() {
                this.certifications.push({ name: '', issuing_authority: '', attained_date: '' });
            },
            removeCert(index) {
                this.certifications.splice(index, 1);
            }
        }
    }
</script>