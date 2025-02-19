# Usar una imagen base de Python slim
FROM python:3.12-slim as base

# Establecer variables de entorno
ENV PYTHONDONTWRITEBYTECODE=1 \
    PYTHONUNBUFFERED=1 \
    FLASK_ENV=production

# Establecer el directorio de trabajo dentro del contenedor
WORKDIR /app

# Instalar dependencias del sistema necesarias
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    gcc \
    default-libmysqlclient-dev \
    pkg-config \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copiar el archivo de dependencias
COPY ../../requirements.txt .

# Instalar las dependencias de Python
RUN pip install --no-cache-dir -r requirements.txt

# Copiar el resto del código de la aplicación
COPY ../../ /app/

# Exponer el puerto en el que corre la API
EXPOSE 5000

# Comando para ejecutar la API con Gunicorn
CMD ["gunicorn", "--bind", "0.0.0.0:5000", "app:app"]