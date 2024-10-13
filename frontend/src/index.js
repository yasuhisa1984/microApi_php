import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';

function App() {
  // 状態管理用のフック。データを保存するために使用します。
  const [data, setData] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // コンポーネントがマウントされたときに実行される副作用
  useEffect(() => {
    // APIエンドポイントをfetchを使ってGETリクエスト
    fetch('http://localhost:8080/api/hello')
      .then((response) => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then((data) => {
        setData(data); // 取得したデータをstateに保存
        setLoading(false); // ローディング終了
      })
      .catch((error) => {
        setError(error);
        setLoading(false);
      });
  }, []); // 空の依存配列で、一度だけ実行

  if (loading) {
    return <div>Loading...</div>;
  }

  if (error) {
    return <div>Error: {error.message}</div>;
  }

  return (
    <div>
      <h1>React + Slim API</h1>
      <p>Message from the server: {data ? data.message : 'No data'}</p>
    </div>
  );
}

// ReactアプリをHTMLのroot要素にレンダリング
ReactDOM.render(
  <React.StrictMode>
    <App />
  </React.StrictMode>,
  document.getElementById('root')
);
