async function viewStudents() {
    const response = await fetch('php/view_students.php');
    const data = await response.json();
    
    let content = '<h2>Students</h2><ul>';
    data.students.forEach(student => {
        content += `<li>${student.username}</li>`;
    });
    content += '</ul>';
    
    document.getElementById('content').innerHTML = content;
}

async function manageExams() {
    const response = await fetch('php/manage_exams.php');
    const data = await response.json();
    
    let content = '<h2>Manage Exams</h2><ul>';
    data.exams.forEach(exam => {
        content += `<li>${exam.name} - <a href="#" onclick="editExam(${exam.id})">Edit</a></li>`;
    });
    content += '</ul>';
    
    document.getElementById('content').innerHTML = content;
}

async function viewResults() {
    const response = await fetch('php/view_results.php');
    const data = await response.json();
    
    let content = '<h2>Exam Results</h2><ul>';
    data.results.forEach(result => {
        content += `<li>${result.student} - ${result.exam} - ${result.score}%</li>`;
    });
    content += '</ul>';
    
    document.getElementById('content').innerHTML = content;
}

async function editExam(examId) {
    const response = await fetch(`php/edit_exam.php?id=${examId}`);
    const data = await response.json();
    
    let content = `<h2>Edit Exam: ${data.exam.name}</h2>`;
    content += '<form id="editExamForm">';
    content += `<input type="hidden" name="id" value="${data.exam.id}">`;
    content += '<label for="name">Exam Name:</label>';
    content += `<input type="text" id="name" name="name" value="${data.exam.name}"><br>`;
    content += '<label for="questions">Questions:</label>';
    data.exam.questions.forEach((question, index) => {
        content += `<input type="text" name="questions[${index}]" value="${question}"><br>`;
    });
    content += '<button type="submit">Save</button>';
    content += '</form>';
    
    document.getElementById('content').innerHTML = content;

    document.getElementById('editExamForm').addEventListener('submit', async (event) => {
        event.preventDefault();
        const formData = new FormData(event.target);
        const response = await fetch('php/save_exam.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        alert(result.message);
        if (result.status === 'success') {
            manageExams();
        }
    });
}

