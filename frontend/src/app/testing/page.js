"use client"

import { useState } from 'react';
import axios from 'axios';
import { useRouter } from 'next/navigation';
import styles from "../page.module.css";

export default function TestingPage() {
    const router = useRouter();

    const handleActionMainPage = () => {
        router.push('/')
    }

    return (
        <div className={styles.page}>
            <main className={styles.main}>
                <h1>Testing results</h1>
                <div className={styles.results_container}>
                    <div>
                        <h3>Rights answers</h3>
                        <div className={styles.results + ' ' + styles.rights}>
                            <span>Question 1</span>
                            <span>Question 2</span>
                            <span>Question 4</span>
                            <span>Question 6</span>
                        </div>
                    </div>
                    <div>
                        <h3>Fails answers</h3>
                        <div className={styles.results + ' ' + styles.fails}>
                            <span>Question 3</span>
                            <span>Question 5</span>
                            <span>Question 7</span>
                            <span>Question 8</span>
                            <span>Question 9</span>
                            <span>Question 10</span>
                        </div>
                    </div>
                </div>
                <button type="button" onClick={handleActionMainPage}>Start again</button>
            </main>
        </div>
    );
}