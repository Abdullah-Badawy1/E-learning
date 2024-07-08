
from flask import Flask, request, render_template, send_file
import os
import PyPDF2
import csv

app = Flask(__name__)

@app.route('/')
def upload_form():
    return render_template('upload.html')

@app.route('/upload', methods=['POST'])
def upload_file():
    if 'file' not in request.files:
        return 'No file part'
    file = request.files['file']
    if file.filename == '':
        return 'No selected file'
    if file:
        # Save the file
        filepath = os.path.join('uploads', file.filename)
        file.save(filepath)
        
        # Process the PDF to generate questions
        questions = extract_questions_from_pdf(filepath)
        
        # Save questions to CSV
        csv_filename = 'questions.csv'
        save_questions_to_csv(questions, csv_filename)
        
        return render_template('questions.html', questions=questions)

@app.route('/download')
def download_file():
    csv_filename = 'questions.csv'
    return send_file(csv_filename, as_attachment=True)

def extract_questions_from_pdf(filepath):
    questions = []
    with open(filepath, 'rb') as file:
        reader = PyPDF2.PdfFileReader(file)
        for page_num in range(reader.numPages):
            page = reader.getPage(page_num)
            text = page.extractText()
            questions.extend(generate_questions_from_text(text))
    return questions

def generate_questions_from_text(text):
    # Dummy implementation, replace with your actual logic
    lines = text.split('\n')
    questions = [line for line in lines if '?' in line]
    return questions

def save_questions_to_csv(questions, filename):
    with open(filename, 'w', newline='') as csvfile:
        writer = csv.writer(csvfile)
        writer.writerow(['Question'])
        for question in questions:
            writer.writerow([question])

if __name__ == '__main__':
    app.run(debug=True)
