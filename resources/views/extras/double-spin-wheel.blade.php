<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Double Spin the Wheel</title>
    <link href="https://fonts.googleapis.com/css2?family=Boogaloo&family=Fredoka+One&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0d0d1a;
            --panel: #12122a;
            --panel2: #1a1a35;
            --gold: #f7c948;
            --gold2: #e8a800;
            --red: #ff4757;
            --green: #2ed573;
            --blue: #1e90ff;
            --purple: #a55eea;
            --cyan: #00d2d3;
            --white: #f1f2f6;
            --muted: #a4b0be;
            --glow: 0 0 20px rgba(247,201,72,0.4);
            --shadow: 0 8px 32px rgba(0,0,0,0.5);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Nunito', sans-serif;
            background: var(--bg);
            color: var(--white);
            min-height: 100vh;
            overflow-x: hidden;
            background-image:
                radial-gradient(ellipse at 20% 10%, rgba(165,94,234,0.12) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 90%, rgba(30,144,255,0.1) 0%, transparent 60%);
        }

        /* Starfield background */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image:
                radial-gradient(1px 1px at 10% 20%, rgba(255,255,255,0.4) 0%, transparent 100%),
                radial-gradient(1px 1px at 30% 70%, rgba(255,255,255,0.3) 0%, transparent 100%),
                radial-gradient(1px 1px at 60% 15%, rgba(255,255,255,0.5) 0%, transparent 100%),
                radial-gradient(1px 1px at 80% 50%, rgba(255,255,255,0.3) 0%, transparent 100%),
                radial-gradient(1px 1px at 45% 85%, rgba(255,255,255,0.4) 0%, transparent 100%),
                radial-gradient(1px 1px at 90% 30%, rgba(255,255,255,0.2) 0%, transparent 100%),
                radial-gradient(1px 1px at 5% 55%, rgba(255,255,255,0.3) 0%, transparent 100%),
                radial-gradient(1px 1px at 70% 80%, rgba(255,255,255,0.4) 0%, transparent 100%);
            pointer-events: none;
            z-index: 0;
        }

        header {
            text-align: center;
            padding: 28px 20px 16px;
            position: relative;
            z-index: 1;
        }

        header h1 {
            font-family: 'Fredoka One', cursive;
            font-size: clamp(2rem, 5vw, 3.2rem);
            letter-spacing: 2px;
            background: linear-gradient(135deg, var(--gold), #ff6b6b, var(--purple), var(--cyan));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: none;
            filter: drop-shadow(0 0 18px rgba(247,201,72,0.5));
        }

        header p {
            color: var(--muted);
            font-size: 0.95rem;
            margin-top: 4px;
            letter-spacing: 0.5px;
        }

        .app-layout {
            display: flex;
            gap: 28px;
            padding: 10px 30px 30px;
            max-width: 1200px;
            margin: 0 auto;
            align-items: flex-start;
            position: relative;
            z-index: 1;
        }

        /* ── WHEEL SECTION ── */
        .wheel-section {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .wheel-container {
            position: relative;
            width: 420px;
            height: 420px;
        }

        /* Glow ring behind outer wheel */
        .wheel-container::before {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            background: conic-gradient(from 0deg, var(--gold), var(--purple), var(--cyan), var(--red), var(--gold));
            opacity: 0;
            transition: opacity 0.4s;
            z-index: -1;
            filter: blur(12px);
        }
        .wheel-container.spinning::before { opacity: 0.6; }

        #outer-canvas {
            position: absolute;
            top: 0; left: 0;
            width: 420px; height: 420px;
            border-radius: 50%;
            filter: drop-shadow(0 0 16px rgba(247,201,72,0.35));
        }

        #inner-canvas {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            filter: drop-shadow(0 0 10px rgba(0,210,211,0.5));
        }

        /* Pointer arrow */
        .pointer {
            position: absolute;
            top: -18px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 14px solid transparent;
            border-right: 14px solid transparent;
            border-top: 30px solid var(--gold);
            filter: drop-shadow(0 4px 8px rgba(247,201,72,0.7));
            z-index: 10;
        }

        /* Center hub */
        .hub {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 18px; height: 18px;
            background: var(--white);
            border-radius: 50%;
            border: 3px solid var(--bg);
            z-index: 20;
            box-shadow: 0 0 12px rgba(255,255,255,0.6);
        }

        /* SPIN button */
        .spin-btn {
            font-family: 'Fredoka One', cursive;
            font-size: 1.5rem;
            letter-spacing: 3px;
            padding: 14px 56px;
            background: linear-gradient(135deg, var(--gold2), var(--gold));
            color: #1a1000;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 4px 0 #a06c00, 0 8px 24px rgba(247,201,72,0.4);
            transition: transform 0.1s, box-shadow 0.1s;
            position: relative;
            overflow: hidden;
        }
        .spin-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 0 #a06c00, 0 12px 32px rgba(247,201,72,0.55);
        }
        .spin-btn:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 #a06c00, 0 4px 16px rgba(247,201,72,0.3);
        }
        .spin-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        .spin-btn::after {
            content: '';
            position: absolute;
            top: -50%; left: -60%;
            width: 40%; height: 200%;
            background: rgba(255,255,255,0.3);
            transform: skewX(-20deg);
            animation: sheen 3s infinite 1s;
        }
        @keyframes sheen {
            0% { left: -60%; }
            30%, 100% { left: 130%; }
        }

        /* ── INPUTS SECTION ── */
        .inputs-section {
            flex: 0 0 260px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .input-panel {
            background: var(--panel);
            border-radius: 16px;
            padding: 18px;
            border: 1px solid rgba(255,255,255,0.07);
            box-shadow: var(--shadow);
        }

        .input-panel h3 {
            font-family: 'Fredoka One', cursive;
            font-size: 1.1rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .panel-outer h3 { color: var(--gold); }
        .panel-inner h3 { color: var(--cyan); }

        .input-panel h3 .dot {
            width: 10px; height: 10px;
            border-radius: 50%;
            display: inline-block;
        }
        .panel-outer .dot { background: var(--gold); box-shadow: 0 0 8px var(--gold); }
        .panel-inner .dot { background: var(--cyan); box-shadow: 0 0 8px var(--cyan); }

        .input-panel textarea {
            width: 100%;
            height: 130px;
            background: var(--panel2);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            color: var(--white);
            font-family: 'Nunito', sans-serif;
            font-size: 0.9rem;
            padding: 10px 12px;
            resize: vertical;
            line-height: 1.6;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .panel-outer textarea:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(247,201,72,0.15);
        }
        .panel-inner textarea:focus {
            border-color: var(--cyan);
            box-shadow: 0 0 0 3px rgba(0,210,211,0.15);
        }

        .input-hint {
            font-size: 0.75rem;
            color: var(--muted);
            margin-top: 6px;
        }

        .item-count {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            margin-left: auto;
        }
        .panel-outer .item-count { background: rgba(247,201,72,0.15); color: var(--gold); }
        .panel-inner .item-count { background: rgba(0,210,211,0.15); color: var(--cyan); }

        /* ── MODAL ── */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.75);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s;
        }
        .modal-overlay.show {
            opacity: 1;
            pointer-events: all;
        }

        .modal {
            background: linear-gradient(145deg, #1c1c3a, #12122a);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 24px;
            padding: 40px 48px;
            text-align: center;
            max-width: 480px;
            width: 90%;
            box-shadow: 0 24px 80px rgba(0,0,0,0.7), 0 0 0 1px rgba(247,201,72,0.2);
            transform: scale(0.8) translateY(30px);
            transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
            position: relative;
            overflow: hidden;
        }
        .modal-overlay.show .modal {
            transform: scale(1) translateY(0);
        }

        /* Shimmer top bar */
        .modal::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--gold), var(--purple), var(--cyan), var(--gold));
            background-size: 200% 100%;
            animation: shimmer 2s linear infinite;
        }
        @keyframes shimmer {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }

        .modal-confetti {
            font-size: 2.5rem;
            animation: bounce 0.6s ease infinite alternate;
            display: block;
            margin-bottom: 10px;
        }
        @keyframes bounce {
            from { transform: translateY(0); }
            to { transform: translateY(-8px); }
        }

        .modal h2 {
            font-family: 'Fredoka One', cursive;
            font-size: 1.9rem;
            margin-bottom: 28px;
            background: linear-gradient(135deg, var(--gold), #ffb347);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .result-cards {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }

        .result-card {
            flex: 1 1 140px;
            background: var(--panel2);
            border-radius: 16px;
            padding: 20px 16px;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }
        .result-card::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0.07;
            border-radius: 14px;
        }

        .result-card.outer-card {
            border-color: rgba(247,201,72,0.4);
            box-shadow: 0 0 20px rgba(247,201,72,0.15);
        }
        .result-card.outer-card::before { background: var(--gold); }

        .result-card.inner-card {
            border-color: rgba(0,210,211,0.4);
            box-shadow: 0 0 20px rgba(0,210,211,0.15);
        }
        .result-card.inner-card::before { background: var(--cyan); }

        .result-card .card-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 800;
            margin-bottom: 8px;
        }
        .outer-card .card-label { color: var(--gold); }
        .inner-card .card-label { color: var(--cyan); }

        .result-card .card-value {
            font-family: 'Boogaloo', cursive;
            font-size: 1.6rem;
            color: var(--white);
            word-break: break-word;
            line-height: 1.2;
        }

        .modal-close {
            font-family: 'Fredoka One', cursive;
            font-size: 1.1rem;
            letter-spacing: 2px;
            padding: 12px 40px;
            background: transparent;
            border: 2px solid rgba(247,201,72,0.5);
            color: var(--gold);
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .modal-close:hover {
            background: rgba(247,201,72,0.1);
            border-color: var(--gold);
            box-shadow: 0 0 16px rgba(247,201,72,0.3);
        }

        .remove-btn {
            margin-top: 12px;
            width: 100%;
            font-family: 'Nunito', sans-serif;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 7px 10px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }

        .remove-btn .btn-icon {
            font-size: 0.85rem;
            line-height: 1;
        }

        .remove-btn-outer {
            background: rgba(247,201,72,0.12);
            color: var(--gold);
            border: 1px solid rgba(247,201,72,0.3);
        }
        .remove-btn-outer:hover {
            background: rgba(247,201,72,0.22);
            border-color: rgba(247,201,72,0.6);
            box-shadow: 0 0 12px rgba(247,201,72,0.2);
            transform: translateY(-1px);
        }
        .remove-btn-outer:active { transform: translateY(1px); }

        .remove-btn-inner {
            background: rgba(0,210,211,0.12);
            color: var(--cyan);
            border: 1px solid rgba(0,210,211,0.3);
        }
        .remove-btn-inner:hover {
            background: rgba(0,210,211,0.22);
            border-color: rgba(0,210,211,0.6);
            box-shadow: 0 0 12px rgba(0,210,211,0.2);
            transform: translateY(-1px);
        }
        .remove-btn-inner:active { transform: translateY(1px); }

        .remove-btn:disabled {
            opacity: 0.35;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
        }

        /* Strike-through animation when removed */
        .card-value.removed {
            position: relative;
            opacity: 0.45;
            transition: opacity 0.3s;
        }
        .card-value.removed::after {
            content: '';
            position: absolute;
            left: 0; right: 0;
            top: 50%;
            height: 3px;
            background: currentColor;
            border-radius: 2px;
            animation: strikeIn 0.3s ease forwards;
        }
        @keyframes strikeIn {
            from { transform: scaleX(0); }
            to   { transform: scaleX(1); }
        }

        .removed-badge {
            display: inline-block;
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 2px 7px;
            border-radius: 20px;
            margin-top: 5px;
            background: rgba(255,71,87,0.2);
            color: var(--red);
            border: 1px solid rgba(255,71,87,0.3);
        }

        /* Firework particles */
        .particle {
            position: fixed;
            pointer-events: none;
            border-radius: 50%;
            animation: particle-fly 1s ease-out forwards;
            z-index: 1001;
        }
        @keyframes particle-fly {
            0% { opacity: 1; transform: translate(0,0) scale(1); }
            100% { opacity: 0; transform: translate(var(--dx), var(--dy)) scale(0); }
        }

        @media (max-width: 780px) {
            .app-layout {
                flex-direction: column;
                align-items: center;
                padding: 10px 16px 30px;
            }
            .inputs-section { flex: none; width: 100%; max-width: 420px; flex-direction: row; flex-wrap: wrap; }
            .input-panel { flex: 1 1 180px; }
            .wheel-container { width: 320px; height: 320px; }
            #outer-canvas { width: 320px; height: 320px; }
        }
    </style>
</head>
<body>

<header>
    <h1>🎡 Double Spin the Wheel</h1>
    <p>Two wheels. One spin. Endless surprises!</p>
</header>

<div class="app-layout">

    <!-- WHEEL -->
    <div class="wheel-section">
        <div class="wheel-container" id="wheelContainer">
            <div class="pointer"></div>
            <canvas id="outer-canvas" width="420" height="420"></canvas>
            <canvas id="inner-canvas" width="170" height="170"></canvas>
            <div class="hub"></div>
        </div>
        <button class="spin-btn" id="spinBtn">SPIN</button>
    </div>

    <!-- INPUTS -->
    <div class="inputs-section">

        <div class="input-panel panel-outer">
            <h3>
                <span class="dot"></span>
                Outer Wheel
                <span class="item-count" id="outer-count">4</span>
            </h3>
            <textarea id="outer-input" spellcheck="false">Name 1
Name 2
Name 3
Name 4</textarea>
            <div class="input-hint">One item per line (max 12)</div>
        </div>

        <div class="input-panel panel-inner">
            <h3>
                <span class="dot"></span>
                Inner Wheel
                <span class="item-count" id="inner-count">4</span>
            </h3>
            <textarea id="inner-input" spellcheck="false">Prize 1
Prize 2
Prize 3
Prize 4</textarea>
            <div class="input-hint">One item per line (max 12)</div>
        </div>

    </div>
</div>

<!-- MODAL -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <span class="modal-confetti">🎉</span>
        <h2>We Have Winners!</h2>
        <div class="result-cards">
            <div class="result-card outer-card">
                <div class="card-label">🏆 Outer Wheel</div>
                <div class="card-value" id="result-outer">—</div>
                <div id="outer-removed-badge" style="display:none"><span class="removed-badge">✕ Removed</span></div>
                <button class="remove-btn remove-btn-outer" id="remove-outer-btn">
                    <span class="btn-icon">✕</span> Remove from Wheel
                </button>
            </div>
            <div class="result-card inner-card">
                <div class="card-label">🎁 Inner Wheel</div>
                <div class="card-value" id="result-inner">—</div>
                <div id="inner-removed-badge" style="display:none"><span class="removed-badge">✕ Removed</span></div>
                <button class="remove-btn remove-btn-inner" id="remove-inner-btn">
                    <span class="btn-icon">✕</span> Remove from Wheel
                </button>
            </div>
        </div>
        <button class="modal-close" id="modalClose">AWESOME!</button>
    </div>
</div>

<script>
    // ─── Color palettes ───────────────────────────────────────────────
    const OUTER_COLORS = [
        ['#ff6b6b','#c0392b'],['#feca57','#e67e22'],['#48dbfb','#0984e3'],
        ['#ff9ff3','#a55eea'],['#1dd1a1','#10ac84'],['#ff9f43','#ee5a24'],
        ['#54a0ff','#2e86de'],['#5f27cd','#341f97'],['#01CBC6','#006266'],
        ['#e84393','#833471'],['#a29bfe','#6c5ce7'],['#fd79a8','#e84393']
    ];
    const INNER_COLORS = [
        ['#00d2d3','#0abde3'],['#2ed573','#1e9e54'],['#ffd32a','#cc8800'],
        ['#ff6b81','#ee5a24'],['#a55eea','#7c3ae0'],['#eccc68','#c39b0e'],
        ['#70a1ff','#1e90ff'],['#7bed9f','#2ed573'],['#ff4757','#c0392b'],
        ['#26de81','#20bf6b'],['#45aaf2','#2d98da'],['#fd9644','#e67e22']
    ];

    // ─── State ────────────────────────────────────────────────────────
    let outerItems = [];
    let innerItems = [];
    let outerAngle = 0;
    let innerAngle = 0;
    let isSpinning = false;

    // ─── Canvas setup ─────────────────────────────────────────────────
    const outerCanvas = document.getElementById('outer-canvas');
    const outerCtx    = outerCanvas.getContext('2d');
    const innerCanvas = document.getElementById('inner-canvas');
    const innerCtx    = innerCanvas.getContext('2d');

    // ─── Parse textarea ───────────────────────────────────────────────
    function parseItems(text, max = 12) {
        return text.split('\n')
            .map(l => l.trim())
            .filter(l => l.length > 0)
            .slice(0, max);
    }

    function getItems() {
        outerItems = parseItems(document.getElementById('outer-input').value);
        innerItems = parseItems(document.getElementById('inner-input').value);
        if (outerItems.length < 2) outerItems = ['Item 1', 'Item 2'];
        if (innerItems.length < 2) innerItems = ['Item 1', 'Item 2'];
        document.getElementById('outer-count').textContent = outerItems.length;
        document.getElementById('inner-count').textContent = innerItems.length;
    }

    // ─── Draw wheel ───────────────────────────────────────────────────
    function drawWheel(ctx, cx, cy, radius, items, colors, angle, type) {
        const n = items.length;
        const slice = (2 * Math.PI) / n;

        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);

        for (let i = 0; i < n; i++) {
            const start = angle + i * slice;
            const end   = start + slice;
            const [fill, dark] = colors[i % colors.length];

            // Segment fill
            ctx.beginPath();
            ctx.moveTo(cx, cy);
            ctx.arc(cx, cy, radius, start, end);
            ctx.closePath();

            const grad = ctx.createRadialGradient(cx, cy, 0, cx, cy, radius);
            grad.addColorStop(0, lighten(fill, 30));
            grad.addColorStop(1, fill);
            ctx.fillStyle = grad;
            ctx.fill();

            // Segment border
            ctx.strokeStyle = 'rgba(0,0,0,0.35)';
            ctx.lineWidth = type === 'outer' ? 2 : 1.5;
            ctx.stroke();

            // Label
            ctx.save();
            ctx.translate(cx, cy);
            ctx.rotate(start + slice / 2);
            ctx.textAlign = 'right';
            ctx.textBaseline = 'middle';
            const labelR = radius * (type === 'outer' ? 0.78 : 0.72);
            const fontSize = type === 'outer'
                ? Math.min(16, Math.max(9, Math.floor(radius * 0.13)))
                : Math.min(11, Math.max(7, Math.floor(radius * 0.15)));

            ctx.font = `bold ${fontSize}px 'Nunito', sans-serif`;
            ctx.fillStyle = '#fff';
            ctx.shadowColor = 'rgba(0,0,0,0.8)';
            ctx.shadowBlur = 4;

            let label = items[i];
            const maxChars = type === 'outer' ? 14 : 9;
            if (label.length > maxChars) label = label.slice(0, maxChars - 1) + '…';
            ctx.fillText(label, labelR, 0);
            ctx.restore();
        }

        // Rim
        ctx.beginPath();
        ctx.arc(cx, cy, radius, 0, 2 * Math.PI);
        ctx.strokeStyle = type === 'outer'
            ? 'rgba(247,201,72,0.9)'
            : 'rgba(0,210,211,0.9)';
        ctx.lineWidth = type === 'outer' ? 4 : 3;
        ctx.stroke();

        // Inner shadow ring
        ctx.beginPath();
        ctx.arc(cx, cy, radius - 3, 0, 2 * Math.PI);
        ctx.strokeStyle = 'rgba(0,0,0,0.3)';
        ctx.lineWidth = 6;
        ctx.stroke();
    }

    function lighten(hex, pct) {
        const num = parseInt(hex.replace('#',''), 16);
        const r = Math.min(255, (num >> 16) + Math.round(((255 - (num >> 16)) * pct) / 100));
        const g = Math.min(255, ((num >> 8) & 0xff) + Math.round(((255 - ((num >> 8) & 0xff)) * pct) / 100));
        const b = Math.min(255, (num & 0xff) + Math.round(((255 - (num & 0xff)) * pct) / 100));
        return `rgb(${r},${g},${b})`;
    }

    function renderAll() {
        // Outer wheel — full canvas
        const oc = 210, or = 200;
        drawWheel(outerCtx, oc, oc, or, outerItems, OUTER_COLORS, outerAngle, 'outer');

        // Inner wheel — smaller canvas centered in outer
        const ic = 85, ir = 78;
        drawWheel(innerCtx, ic, ic, ir, innerItems, INNER_COLORS, innerAngle, 'inner');
    }

    // ─── Winner calculation ───────────────────────────────────────────
    function getWinner(items, angle) {
        const n = items.length;
        const slice = (2 * Math.PI) / n;
        // Pointer at top = -π/2 relative to canvas coords
        const pointer = -Math.PI / 2;
        const normalized = ((pointer - angle) % (2 * Math.PI) + 2 * Math.PI) % (2 * Math.PI);
        const idx = Math.floor(normalized / slice) % n;
        return items[idx];
    }

    // ─── Spin animation ───────────────────────────────────────────────
    function spin() {
        if (isSpinning) return;
        getItems();
        renderAll();
        isSpinning = true;
        document.getElementById('spinBtn').disabled = true;
        document.getElementById('wheelContainer').classList.add('spinning');

        // Random spin amounts (radians)
        const outerExtra = (5 + Math.random() * 5) * 2 * Math.PI; // 5-10 full rotations
        const innerExtra = (7 + Math.random() * 6) * 2 * Math.PI; // inner spins faster/more

        // Random direction (inner can spin opposite)
        const outerDir = 1;
        const innerDir = Math.random() > 0.4 ? 1 : -1;

        const outerTarget = outerAngle + outerDir * outerExtra;
        const innerTarget = innerAngle + innerDir * innerExtra;

        const duration = 4500 + Math.random() * 1500; // 4.5 – 6s
        const startTime = performance.now();
        const startOuter = outerAngle;
        const startInner = innerAngle;

        function easeOut(t) {
            return 1 - Math.pow(1 - t, 4);
        }

        function frame(now) {
            const elapsed = now - startTime;
            const t = Math.min(elapsed / duration, 1);
            const e = easeOut(t);

            outerAngle = startOuter + (outerTarget - startOuter) * e;
            innerAngle = startInner + (innerTarget - startInner) * e;
            renderAll();

            if (t < 1) {
                requestAnimationFrame(frame);
            } else {
                outerAngle = outerTarget;
                innerAngle = innerTarget;
                renderAll();
                isSpinning = false;
                document.getElementById('spinBtn').disabled = false;
                document.getElementById('wheelContainer').classList.remove('spinning');
                showResult();
            }
        }

        requestAnimationFrame(frame);
    }

    // ─── Modal ────────────────────────────────────────────────────────
    function showResult() {
        const outerWinner = getWinner(outerItems, outerAngle);
        const innerWinner = getWinner(innerItems, innerAngle);

        document.getElementById('result-outer').textContent = outerWinner;
        document.getElementById('result-outer').classList.remove('removed');
        document.getElementById('result-inner').textContent = innerWinner;
        document.getElementById('result-inner').classList.remove('removed');

        // Reset remove buttons
        const removeOuter = document.getElementById('remove-outer-btn');
        const removeInner = document.getElementById('remove-inner-btn');
        removeOuter.disabled = false;
        removeOuter.innerHTML = '<span class="btn-icon">✕</span> Remove from Wheel';
        removeInner.disabled = false;
        removeInner.innerHTML = '<span class="btn-icon">✕</span> Remove from Wheel';
        document.getElementById('outer-removed-badge').style.display = 'none';
        document.getElementById('inner-removed-badge').style.display = 'none';

        document.getElementById('modalOverlay').classList.add('show');
        spawnParticles();
    }

    function hideModal() {
        document.getElementById('modalOverlay').classList.remove('show');
    }

    // ─── Remove winner from list ──────────────────────────────────────
    function removeWinner(type) {
        const inputId  = type === 'outer' ? 'outer-input' : 'inner-input';
        const resultId = type === 'outer' ? 'result-outer' : 'result-inner';
        const btnId    = type === 'outer' ? 'remove-outer-btn' : 'remove-inner-btn';
        const badgeId  = type === 'outer' ? 'outer-removed-badge' : 'inner-removed-badge';

        const winner   = document.getElementById(resultId).textContent.trim();
        const textarea = document.getElementById(inputId);

        // Remove the winner line (case-insensitive exact match)
        const lines    = textarea.value.split('\n');
        const filtered = lines.filter(l => l.trim().toLowerCase() !== winner.toLowerCase());
        textarea.value = filtered.join('\n');

        // Refresh items & wheel
        getItems();
        renderAll();

        // Visual feedback on the card
        document.getElementById(resultId).classList.add('removed');
        document.getElementById(badgeId).style.display = 'block';
        const btn = document.getElementById(btnId);
        btn.disabled = true;
        btn.innerHTML = '<span class="btn-icon">✓</span> Removed!';
    }

    // ─── Confetti particles ───────────────────────────────────────────
    function spawnParticles() {
        const colors = ['#f7c948','#ff4757','#2ed573','#1e90ff','#a55eea','#00d2d3','#ff6b6b'];
        const cx = window.innerWidth / 2;
        const cy = window.innerHeight / 2;

        for (let i = 0; i < 60; i++) {
            setTimeout(() => {
                const p = document.createElement('div');
                p.className = 'particle';
                const size = 6 + Math.random() * 8;
                const angle = Math.random() * 2 * Math.PI;
                const dist  = 120 + Math.random() * 260;
                p.style.cssText = `
        width:${size}px; height:${size}px;
        left:${cx}px; top:${cy}px;
        background:${colors[Math.floor(Math.random()*colors.length)]};
        --dx:${Math.cos(angle)*dist}px;
        --dy:${Math.sin(angle)*dist}px;
        animation-duration:${0.8 + Math.random()*0.6}s;
      `;
                document.body.appendChild(p);
                setTimeout(() => p.remove(), 1500);
            }, i * 20);
        }
    }

    // ─── Count updater ────────────────────────────────────────────────
    function updateCount(inputId, countId) {
        const items = parseItems(document.getElementById(inputId).value);
        document.getElementById(countId).textContent = Math.max(items.length, 2);
    }

    // ─── Init ─────────────────────────────────────────────────────────
    document.getElementById('spinBtn').addEventListener('click', spin);
    document.getElementById('modalClose').addEventListener('click', hideModal);
    document.getElementById('modalOverlay').addEventListener('click', (e) => {
        if (e.target === document.getElementById('modalOverlay')) hideModal();
    });
    document.getElementById('remove-outer-btn').addEventListener('click', () => removeWinner('outer'));
    document.getElementById('remove-inner-btn').addEventListener('click', () => removeWinner('inner'));

    document.getElementById('outer-input').addEventListener('input', () => {
        updateCount('outer-input','outer-count');
        getItems(); renderAll();
    });
    document.getElementById('inner-input').addEventListener('input', () => {
        updateCount('inner-input','inner-count');
        getItems(); renderAll();
    });

    // Initial render
    getItems();
    renderAll();
</script>
</body>
</html>
