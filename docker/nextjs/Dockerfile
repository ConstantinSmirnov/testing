# Используем официальный образ Node.js как базовый образ
FROM node:18

# Устанавливаем рабочую директорию
WORKDIR /var/www

# Копируем package.json и package-lock.json из папки frontend
COPY ./frontend/package*.json ./

# Устанавливаем зависимости
RUN npm install

# Копируем оставшиеся файлы проекта из папки frontend
COPY ./frontend ./

# Создаем билд
RUN npm run build

# Устанавливаем переменную окружения для порта
ENV PORT=3000

# Открываем порт
EXPOSE 3000

# Команда для запуска приложения
CMD [ "npm", "start" ]
