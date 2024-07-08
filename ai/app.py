
import os
import PyPDF2
import google.generativeai as genai
from flask import Flask, request, jsonify, render_template, send_file
from werkzeug.utils import secure_filename
import csv

# Initialize the Flask application
app = Flask(__name__)
app.config['UPLOAD_FOLDER'] = 'uploads'
app.config['ALLOWED_EXTENSIONS'] = {'pdf'}

# Configure the Gemini API with the provided API key
genai.configure(api_key="AIzaSyCpl89wWkV5D-Be0jYAR4_xZZon5i9_bSc")

# Initialize the generative model
model = genai.GenerativeModel('gemini-1.5-flash')

# Check if the file extension is allowed
def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in app.config['ALLOWED_EXTENSIONS']

# Extract text from PDF using PdfReader
def extract_text_from_pdf(pdf_path):
    with open(pdf_path, 'rb') as file:
        reader = PyPDF2.PdfReader(file)
        text = ''
        for page_num in range(len(reader.pages)):
            text += reader.pages[page_num].extract_text()
    return text

# Generate questions using Gemini API
def generate_questions(text, question_types, num_questions):
    questions = []
    for question_type in question_types:
        prompt = f"Generate {num_questions} {question_type} questions from the following text:\n\n{text}"
        response = model.generate_content(prompt)
        questions.extend(response.text.split('\n'))
    return questions

def save_questions_to_csv(questions, filename):
    with open(filename, 'w', newline='') as csvfile:
        writer = csv.writer(csvfile)
        writer.writerow(['Question'])
        for question in questions:
            writer.writerow([question])

# Flask routes
@app.route('/')
def upload_file():
    return render_template('upload.html')

@app.route('/upload', methods=['POST'])
def upload_file_post():
    if 'file' not in request.files:
        return jsonify({'error': 'No file part'})

    file = request.files['file']
    if file.filename == '':
        return jsonify({'error': 'No selected file'})

    if file and allowed_file(file.filename):
        filename = secure_filename(file.filename)
        filepath = os.path.join(app.config['UPLOAD_FOLDER'], filename)
        os.makedirs(os.path.dirname(filepath), exist_ok=True)
        file.save(filepath)

        question_types = request.form.getlist('question_types')
        num_questions = int(request.form['num_questions'])

        text = extract_text_from_pdf(filepath)

        questions = generate_questions(text, question_types, num_questions)

        csv_filename = 'questions.csv'
        save_questions_to_csv(questions, csv_filename)

        return render_template('questions.html', questions=questions)
    
    else:
        return jsonify({'error': 'File type not allowed'})

@app.route('/download')
def download_file():
    csv_filename = 'questions.csv'
    return send_file(csv_filename, as_attachment=True)

if __name__ == '__main__':
    app.run(debug=True)
