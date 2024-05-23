let currentStep = 1;

function nextStep() {
    if (currentStep < 4) {
        document.getElementById(`step-${currentStep}`).classList.add('hidden');
        currentStep++;
        document.getElementById(`step-${currentStep}`).classList.remove('hidden');

        // Update button text based on step
        const submitButton = document.getElementById('submitButton');
        submitButton.textContent = currentStep === 4 ? 'Submit' : 'Next';
    } else {
        // Submit the form on the last step
        document.getElementById('form').submit();
    }
}

function prevStep() {
    if (currentStep > 1) {
        document.getElementById(`step-${currentStep}`).classList.add('hidden');
        currentStep--;
        document.getElementById(`step-${currentStep}`).classList.remove('hidden');
    }
}
