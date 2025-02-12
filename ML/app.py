from flask import Flask, request, jsonify
from flask_cors import CORS
import numpy as np
import joblib

#Load the ML model
model = joblib.load('gastos_classifier.pkl')

#Create my flask app
app = Flask(__name__)
CORS(app)

#My API endpoints
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
    app.run(port=3000)