const startBtn = document.getElementById('start');
const stopBtn = document.getElementById('stop');
const numberEl = document.getElementById('number');

let intervalId = null;

function start() {
    if (intervalId === null) {
        intervalId = setInterval(() => {
            const randomNumber = Math.floor(Math.random() * 10) + 1;
            numberEl.innerText = randomNumber;
            if (randomNumber % 2 === 0) {
                numberEl.insertAdjacentHTML('afterend', '<p>Even</p>');
            } else {
                numberEl.insertAdjacentHTML('afterend', '<p>Odd</p>');
            }
        }, 1000);
    }
}

function stop() {
    clearInterval(intervalId);
    intervalId = null;
    numberEl.innerText = '';
    // const pEls = document.querySelectorAll('p');
    pEls.forEach(pEl => pEl.remove());
}

startBtn.addEventListener('click', start);
stopBtn.addEventListener('click', stop);