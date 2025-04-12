<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vòng Quay 3D</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #e3ffe7 0%, #d9e7ff 100%);
            overflow: hidden;
        }
        #wheel {
            width: 300px;
            height: 300px;
            position: relative;
            border-radius: 50%;
            border: 10px solid #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            transform-style: preserve-3d;
            transition: transform 4s cubic-bezier(0.33, 1, 0.68, 1);
        }
        .segment {
            position: absolute;
            width: 50%;
            height: 50%;
            background: #f39c12;
            transform-origin: 100% 100%;
            clip-path: polygon(0 0, 100% 0, 100% 100%);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            text-shadow: 1px 1px 2px #000;
        }
        #spinner {
            position: relative;
            width: 300px;
            height: 300px;
            transform: perspective(1000px) rotateX(20deg);
        }
        #pointer {
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 20px solid transparent;
            border-right: 20px solid transparent;
            border-bottom: 30px solid red;
            z-index: 2;
        }
        #spinButton {
            position: absolute;
            bottom: -80px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 20px;
            font-size: 16px;
            background: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div id="spinner">
    <div id="pointer"></div>
    <div id="wheel"></div>
    <button id="spinButton">Quay</button>
</div>

<script>
    const wheel = document.getElementById("wheel");
    const spinButton = document.getElementById("spinButton");

    // Danh sách phần quà có thể thay đổi: 4, 6, 8, 10 phần
    const rewards = ["Quà 1", "Quà 2", "Quà 3", "Quà 4", "Quà 5", "Quà 6", "Quà 7", "Quà 8"];

    function drawWheel(rewards) {
        wheel.innerHTML = "";
        const slice = 360 / rewards.length;

        rewards.forEach((reward, i) => {
            const segment = document.createElement("div");
            segment.className = "segment";
            segment.style.background = i % 2 === 0 ? "#e74c3c" : "#2ecc71";
            segment.style.transform = `rotate(${i * slice}deg) skewY(${90 - slice}deg)`;
            segment.innerText = reward;
            wheel.appendChild(segment);
        });
    }

    drawWheel(rewards);

    let isSpinning = false;
    spinButton.addEventListener("click", () => {
        if (isSpinning) return;
        isSpinning = true;

        const randomDegree = 360 * 5 + Math.floor(Math.random() * 360);
        wheel.style.transition = "transform 5s ease-out";
        wheel.style.transform = `rotate(${randomDegree}deg)`;

        setTimeout(() => {
            isSpinning = false;
            const finalDeg = randomDegree % 360;
            const rewardIndex = Math.floor(rewards.length - (finalDeg / 360) * rewards.length) % rewards.length;
            alert("Bạn trúng: " + rewards[rewardIndex]);
        }, 5200);
    });
</script>
</body>
</html>
