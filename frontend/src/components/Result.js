"use client";

import { useState, useEffect } from 'react';
import axios from 'axios';
import styles from "../app/page.module.css";

export default function Result({session: session, handleBack: handleBack}) {
    const [isModalVisible, setModalVisible] = useState(false);
    const [isSubmitting, setSubmitting] = useState(false);
    const [errorMessage, setErrorMessage] = useState('');
    const [data, setData] = useState({ rights: [], fails: [] });

    useEffect(() => {
        const fetchData = async () => {
            setModalVisible(true);
            setSubmitting(true);

            try {
                const response = await axios.get('http://127.0.0.1:888/api/v1/testing/result', {
                    params: {
                        session: session
                    },
                    headers: {
                        'Content-Type': 'application/json',
                    }
                });
                setData(response.data.data || { rights: [], fails: [] });
            } catch (error) {
                setErrorMessage(error.response?.data?.error || 'An error occurred');
            } finally {
                setModalVisible(false);
                setSubmitting(false);
            }
        };

        fetchData();
    }, [session]);

    const handleActionMainPage = () => {
        handleBack()
    };

    return (
        <div className={styles.page}>
            <main className={styles.main}>
                <h1>Testing results</h1>
                <div className={styles.results_container}>
                    <div>
                        <h3>Rights answers</h3>
                        <div className={`${styles.results} ${styles.rights}`}>
                            {data.rights.length > 0 ? (
                                data.rights.map((item, index) => (
                                    <span key={index}>{item}</span>
                                ))
                            ) : (
                                <span>No rights answers</span>
                            )}
                        </div>
                    </div>
                    <div>
                        <h3>Fails answers</h3>
                        <div className={`${styles.results} ${styles.fails}`}>
                            {data.fails.length > 0 ? (
                                data.fails.map((item, index) => (
                                    <span key={index}>{item}</span>
                                ))
                            ) : (
                                <span>No fails answers</span>
                            )}
                        </div>
                    </div>
                </div>
                <button type="button" onClick={handleActionMainPage}>Start again</button>
            </main>

            <div className={`${styles.modal} ${isModalVisible ? styles.show : ''}`}>
                <div className={styles.modal_content}>
                    {isSubmitting && !errorMessage ? (
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
