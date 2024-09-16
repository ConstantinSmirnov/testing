"use client"

import { useState } from 'react';
import axios from 'axios';
import { useRouter } from 'next/navigation';
import styles from "./page.module.css";

export default function Home() {
    const [isModalVisible, setModalVisible] = useState(false);
    const [isSubmitting, setSubmitting] = useState(false);
    const [errorMessage, setErrorMessage] = useState('');
    const [questions, setQuestions] = useState([]);
    const [selectedAnswers, setSelectedAnswers] = useState(new Set());
    const [currentQuestionIndex, setCurrentQuestionIndex] = useState(0);
    const [currentSession, setCurrentSession] = useState(0);
    const [isCurrentSessionEnd, setCurrentSessionIsEnd] = useState(false);
    const router = useRouter();

    const handleSubmit = async (event) => {
        event.preventDefault();
        setModalVisible(true);
        setSubmitting(true);

        try {
            const response = await axios.post('http://127.0.0.1:888/api/v1/testing/start', {
                name: event.target.username.value
            }, {
                headers: {
                    'Content-Type': 'application/json',
                }
            });

            setCurrentSession(response.data.session.id)
            setCurrentSessionIsEnd(response.data.session.isEnd)
            setQuestions(response.data.data);
            setCurrentQuestionIndex(0);
            setModalVisible(false);
            setSubmitting(false);
        } catch (error) {
            setErrorMessage(error.response?.data?.error || 'An error occurred');
            setModalVisible(true);
            setSubmitting(false);
        }
    };

    const handleAnswerChange = (answerId) => {
        setSelectedAnswers(prevSelectedAnswers => {
            const newSelectedAnswers = new Set(prevSelectedAnswers);
            if (newSelectedAnswers.has(answerId)) {
                newSelectedAnswers.delete(answerId);
            } else {
                newSelectedAnswers.add(answerId);
            }
            return newSelectedAnswers;
        });
    };

    const saveAnswerSubmit = async (event) => {
        event.preventDefault();
        setModalVisible(true);
        setSubmitting(true);

        const currentQuestion = questions[currentQuestionIndex].question.id;
        const selectedAnswerIds = Array.from(selectedAnswers);

        try {
            const response = await axios.post('http://127.0.0.1:888/api/v1/testing/answer/save', {
                session: currentSession,
                question: currentQuestion,
                answers: selectedAnswerIds
            }, {
                headers: {
                    'Content-Type': 'application/json',
                }
            });

            setModalVisible(false);
            setSubmitting(false);
        } catch (error) {
            setErrorMessage(error.response?.data?.error || 'An error occurred');
            setModalVisible(true);
            setSubmitting(false);
        }


        setCurrentQuestionIndex(prevIndex => {
            const nextIndex = prevIndex + 1;
            if (nextIndex < questions.length) {
                return nextIndex;
            } else {
                router.push('/testing')
                return prevIndex;
            }
        });
        setSelectedAnswers([])
    };

    const currentQuestion = questions[currentQuestionIndex];

    return (
        <div className={styles.page}>
            {questions.length === 0 ? (
                <main className={styles.main}>
                    <h1>Testing tasks</h1>
                    <form method="post" className={styles.form} onSubmit={handleSubmit}>
                        <label htmlFor="username">Enter username:</label>
                        <input type="text" id="username" name="username" required />
                        <button type="submit">Submit</button>
                    </form>
                </main>
            ) : (
                <main className={styles.main}>
                    {currentQuestion ? (
                        <div>
                            <h1>Answer the questions</h1>
                            <form method="post" onSubmit={saveAnswerSubmit}>
                                <div className={styles.question_row}>
                                    <div className={styles.question_wrapper}>
                                        <span>{currentQuestion.question.id} question... {currentQuestion.question.text}</span>
                                    </div>
                                    <div className={styles.answer_containter}>
                                        {currentQuestion.answers.map((answer) => (
                                            <div key={answer.id} className={styles.answer_wrapper}>
                                                <div className={styles.answer_row}>
                                                    <input
                                                        type="checkbox"
                                                        id={`answer_${answer.id}`}
                                                        name={`answer_${answer.id}`}
                                                        onChange={() => handleAnswerChange(answer.id)}
                                                    />
                                                    <label htmlFor={`answer_${answer.id}`}>{answer.text}</label>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                    <button type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    ) : (
                        <h1>Loading...</h1>
                    )}
                </main>
            )}

            <div className={`${styles.modal} ${isModalVisible ? styles.show : ''}`}>
                <div className={styles.modal_content}>
                    {isSubmitting ? (
                        <p>Sending data, please wait...</p>
                    ) : errorMessage ? (
                        <p>{errorMessage}</p>
                    ) : (
                        <p>Data has been sent!</p>
                    )}
                </div>
            </div>
        </div>
    );
}
