<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enroll New Student</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body style="font-family: system-ui, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; color: #333;">

    <h1>Enroll New Student</h1>
    <a href="{{ route('admin.students.index') }}"><button>&larr; Back to Directory</button></a>
    <hr>

    @if ($errors->any()) 
        <p style="color: red; padding: 10px; background: #fff5f5; border-radius: 4px; border: 1px solid #f5c2c2;">
            {{ $errors->first() }}
        </p> 
    @endif  

    <form action="{{ route('admin.students.store') }}" 
          method="POST" 
          x-data="studentForm([], [])">
        @csrf 
        
        <h3>1. Primary Accounts Profile</h3>
        <div style="display: flex; gap: 15px; margin-bottom: 10px;">
            <div style="flex: 1;">
                <label style="font-weight:bold;">First Name:</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}" required style="width: 100%; box-sizing: border-box; padding: 8px;">
            </div>
            <div style="flex: 1;">
                <label style="font-weight:bold;">Last Name:</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}" required style="width: 100%; box-sizing: border-box; padding: 8px;">
            </div>
        </div>

        <div style="display: flex; gap: 15px; margin-bottom: 10px;">
            <div style="flex: 1;">
                <label style="font-weight:bold;">Email Address:</label>
                <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; box-sizing: border-box; padding: 8px;">
            </div>
            <div style="flex: 1;">
                <label style="font-weight:bold;">Phone Number:</label>
                <input type="text" name="phone" value="{{ old('phone') }}" style="width: 100%; box-sizing: border-box; padding: 8px;">
            </div>
        </div>

        <div style="display: flex; gap: 15px; margin-bottom: 10px;">
            <div style="flex: 1;">
                <label style="font-weight:bold;">Status:</label>
                <select name="status" required style="width: 100%; padding: 8px;">
                    <option value="active" selected>Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="suspended">Suspended</option>
                </select>
            </div>
            <div style="flex: 1;">
                <label style="font-weight:bold;">Enrollment Date:</label>
                <input type="date" name="enrollment_date" value="{{ old('enrollment_date', date('Y-m-d')) }}" required style="width: 100%; box-sizing: border-box; padding: 8px;">
            </div>
        </div>

        <h3>2. Personal Profile</h3>
        <div style="display: flex; gap: 15px; margin-bottom: 10px;">
            <div style="flex: 1;">
                <label style="font-weight:bold;">Date of Birth:</label>
                <input type="date" name="details[date_of_birth]" value="{{ old('details.date_of_birth') }}" style="width: 100%; box-sizing: border-box; padding: 8px;">
            </div>
            <div style="flex: 1;">
                <label style="font-weight:bold;">Gender:</label>
                <select name="details[gender]" style="width: 100%; padding: 8px;">
                    <option value="">-- Select Gender --</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                    <option value="prefer_not_to_say">Prefer Not to Say</option>
                </select>
            </div>
        </div>

        <div style="margin-bottom: 10px;">
            <label style="font-weight:bold;">National ID / Passport No:</label>
            <input type="text" name="details[national_id_or_passport]" value="{{ old('details.national_id_or_passport') }}" style="width: 100%; box-sizing: border-box; padding: 8px;">
        </div>

        <div style="margin-bottom: 10px;">
            <label style="font-weight:bold;">Home Address:</label>
            <textarea name="details[address]" style="width: 100%; height: 60px; box-sizing: border-box; padding: 8px;">{{ old('details.address') }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-weight:bold;">Academic Credentials / Background Details:</label>
            <textarea name="details[academic_background]" placeholder="Prior certifications, schools attended..." style="width: 100%; height: 80px; box-sizing: border-box; padding: 8px;">{{ old('details.academic_background') }}</textarea>
        </div>

        <h3>3. Emergency Contacts</h3>
        <template x-for="(contact, index) in contacts" :key="index">
            <div style="border:1px solid #ccc; padding:15px; margin-bottom:10px; background: #fff; border-radius: 4px;">
                {{-- One-way ID binding --}}
                <input type="hidden" :name="'emergency_contacts[' + index + '][id]'" :value="contact.id ?? ''">
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 10px; align-items: end;">
                    <div>
                        <label style="display: block; font-size: 0.9em; font-weight: bold;">Name:</label>
                        <input type="text" :name="'emergency_contacts[' + index + '][name]'" x-model="contact.name" required placeholder="Full Name" style="width: 100%; height: 35px; box-sizing: border-box; padding: 5px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.9em; font-weight: bold;">Relationship:</label>
                        <input type="text" :name="'emergency_contacts[' + index + '][relationship]'" x-model="contact.relationship" required placeholder="E.g. Father, Spouse" style="width: 100%; height: 35px; box-sizing: border-box; padding: 5px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.9em; font-weight: bold;">Phone:</label>
                        <input type="text" :name="'emergency_contacts[' + index + '][phone]'" x-model="contact.phone" required placeholder="Phone number" style="width: 100%; height: 35px; box-sizing: border-box; padding: 5px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.9em; font-weight: bold;">Email:</label>
                        <input type="email" :name="'emergency_contacts[' + index + '][email]'" x-model="contact.email" placeholder="Email (Optional)" style="width: 100%; height: 35px; box-sizing: border-box; padding: 5px;">
                    </div>
                </div>
                
                <button type="button" 
                        @click="contacts.splice(index, 1)" 
                        style="margin-top: 10px; color: white; background: #dc3545; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px;">
                    Remove Contact
                </button>
            </div>
        </template>
        <button type="button" @click="contacts.push({ id: null, name: '', relationship: '', phone: '', email: '' })" style="padding: 5px 15px; background: #f0f0f0; border: 1px solid #ccc; cursor: pointer; margin-bottom: 20px;">
            + Add Contact
        </button>

        <br><br>
        <button type="submit" style="padding: 12px 25px; background: #0d6efd; color: white; font-weight: bold; border: none; cursor: pointer; border-radius: 4px;">
            Enroll Student
        </button>
    </form>

    <script>
        function studentForm(initialContacts) {
            const contactsList = Array.isArray(initialContacts) ? initialContacts : [];

            return {
                contacts: contactsList.length 
                    ? contactsList.map(c => ({
                        id: c.id || null,
                        name: c.name || '',
                        relationship: c.relationship || '',
                        phone: c.phone || '',
                        email: c.email || ''
                      }))
                    : [{ id: null, name: '', relationship: '', phone: '', email: '' }]
            }
        }
    </script>
</body>
</html>