from flask import Flask, request, jsonify
from flask_cors import CORS
import requests
import numpy as np
import joblib

#Load the ML model
model = joblib.load('gastos_classifier.pkl')

#Create my flask app
app = Flask(__name__)
CORS(app)

#My API endpoints
@app.route('/greeting', methods=['GET'])
def greeting():
    return "<h1>Hola de nuevo mono 🐒</h1>"

@app.route('/', methods=['GET'])
def hello():
    headers = {
        'Cache-Control': 'no-cache',
        'Pragma': 'no-cache',
        'Content-Type': 'application/json'
    }

    try:
        response = requests.get('http://php-app:8080/', headers=headers)

        if response.status_code == 200:
            data = response.json()
            return jsonify(data)
        else:
            return jsonify({'error': 'Hay un error', 'status_code': response.status_code}), 500

    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/classify', methods=['POST'])
def classify():
    try:
        input_expenses = request.get_json(force=True)
        expenses = int(input_expenses['expenses'])
        expenses = np.array([[expenses]])

        prediction = model.predict(expenses)
        return jsonify({'type_expenses':int(prediction[0])})
    
    except Exception as e:
        print(str(e))
        return jsonify({'error': str(e)}), 400



if __name__ == '__main__':
    app.run(port=3000, debug=True)