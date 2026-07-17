<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate No: {{ $certificate->certificate_number }}</title>
</head>
<body style="font-family: 'Georgia', serif; background: #e2e8f0; margin: 0; padding: 40px; display: flex; justify-content: center; align-items: center; min-height: 100vh;">

    <!-- Certificate Frame -->
    <div style="width: 800px; height: 550px; background: white; border: 20px solid #1e293b; outline: 3px double #d97706; outline-offset: -15px; padding: 40px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); box-sizing: border-box; text-align: center; position: relative;">
        
        <!-- Header Ribbon Decor -->
        <div style="font-family: 'Times New Roman', serif; font-size: 1.25em; letter-spacing: 0.15em; color: #d97706; font-weight: bold; margin-bottom: 20px;">
            ACADEMIC REGISTRY & CREDENTIALS
        </div>

        <h1 style="font-family: 'Georgia', serif; font-size: 3em; font-weight: 400; color: #1e293b; margin: 10px 0;">Certificate of Completion</h1>
        <p style="font-size: 1.1em; color: #475569; font-style: italic; margin-top: 5px;">This academic credential certifies that</p>

        <!-- Student Name -->
        <h2 style="font-size: 2.5em; color: #0f172a; margin: 15px 0; border-bottom: 2px solid #e2e8f0; display: inline-block; padding-bottom: 5px; font-weight: 600;">
            {{ $certificate->enrollment->student->full_name }}
        </h2>

        <p style="font-size: 1.1em; color: #475569; line-height: 1.6; margin: 15px auto; max-width: 550px;">
            has successfully fulfilled all academic curriculums and practical training frameworks prescribed for the professional course:
        </p>

        <!-- Course Name -->
        <h3 style="font-size: 1.85em; color: #1e40af; margin: 10px 0; font-family: system-ui, sans-serif; font-weight: bold;">
            {{ $certificate->enrollment->course->title }}
        </h3>

        <p style="font-size: 1em; color: #64748b; font-style: italic; margin-top: 5px;">
            with a final standing rank level of: <strong>{{ $certificate->grade }}</strong>
        </p>

        <hr style="border: none; border-top: 1px solid #cbd5e1; margin: 30px auto; max-width: 400px;">

        <!-- Signatures and Registration IDs -->
        <div style="display: flex; justify-content: space-between; align-items: flex-end; padding: 0 40px; margin-top: 20px;">
            <div style="text-align: left;">
                <div style="font-family: system-ui, sans-serif; font-size: 0.8em; color: #64748b; text-transform: uppercase;">REGISTRATION NO</div>
                <div style="font-family: system-ui, sans-serif; font-weight: bold; color: #1e293b; margin-top: 3px;">{{ $certificate->certificate_number }}</div>
            </div>

            <div>
                <div style="font-family: 'Brush Script MT', cursive, sans-serif; font-size: 1.8em; color: #1e293b; line-height: 1;">Office of Registry</div>
                <div style="border-top: 1px solid #cbd5e1; margin-top: 5px; width: 180px; font-family: system-ui, sans-serif; font-size: 0.75em; color: #64748b; text-transform: uppercase; padding-top: 5px; text-align: center;">
                    Academic Registrar
                </div>
            </div>

            <div style="text-align: right;">
                <div style="font-family: system-ui, sans-serif; font-size: 0.8em; color: #64748b; text-transform: uppercase;">DATE OF ISSUANCE</div>
                <div style="font-family: system-ui, sans-serif; font-weight: bold; color: #1e293b; margin-top: 3px;">{{ $certificate->issue_date->format('F d, Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Sticky Print Trigger -->
    <div style="position: fixed; bottom: 20px; right: 20px;">
        <button onclick="window.print()" style="padding: 12px 24px; background: #0f172a; color: white; font-family: system-ui, sans-serif; font-weight: bold; border: none; border-radius: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); cursor: pointer; transition: transform 0.1s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            🖨️ Print Certificate
        </button>
    </div>

</body>
</html>