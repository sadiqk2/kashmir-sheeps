<!DOCTYPE html>
<html lang="en" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kashmir Sheeps - Viral Marketing Video Short Simulator</title>
  <script src="https://www.gstatic.com/antigravity/web/dev/tailwindcss.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@700&family=Plus+Jakarta+Sans:wght@400;600;800;900&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .font-urdu {
      font-family: 'Noto Nastaliq Urdu', serif;
    }
    /* Phone frame glow */
    .phone-glow {
      box-shadow: 0 0 60px -15px rgba(16, 185, 129, 0.35);
    }
    /* Pulse animations */
    @keyframes pulseGlow {
      0%, 100% { transform: scale(1); opacity: 1; }
      50% { transform: scale(1.05); opacity: 0.9; }
    }
    .pulse-glow {
      animation: pulseGlow 1.8s infinite ease-in-out;
    }
  </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col items-center justify-center p-3 sm:p-6 antialiased">

  <!-- TOP HEADER & CONTROLS -->
  <header class="max-w-xl w-full flex items-center justify-between mb-4 px-2">
    <div class="flex items-center gap-2.5">
      <a href="/" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 flex items-center justify-center text-sm transition" title="Back to Marketplace">
        ←
      </a>
      <div>
        <h1 class="text-sm font-black flex items-center gap-1.5">
          <span>🐑</span> Kashmir Sheeps Viral Short (9:16)
        </h1>
        <p class="text-[11px] text-slate-400">Instagram Reels & YouTube Shorts Storyboard Simulator</p>
      </div>
    </div>
    <div class="flex items-center gap-2">
      <button id="audioToggleBtn" onclick="toggleAudio()" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-300 flex items-center gap-1.5 transition">
        <span id="audioIcon">🔊</span> <span id="audioLabel">Beat Audio</span>
      </button>
      <button onclick="restartVideo()" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white shadow-md shadow-emerald-600/30 transition flex items-center gap-1">
        ↻ Replay
      </button>
    </div>
  </header>

  <!-- SMARTPHONE 9:16 SIMULATOR CONTAINER -->
  <div class="relative w-[340px] sm:w-[380px] h-[680px] sm:h-[730px] rounded-[48px] bg-black border-[10px] border-slate-800 phone-glow overflow-hidden shadow-2xl flex flex-col justify-between select-none">
    
    <!-- Dynamic Island / Top Camera Notch -->
    <div class="absolute top-2 left-1/2 -translate-x-1/2 w-28 h-6 bg-black rounded-full z-40 flex items-center justify-center pointer-events-none">
      <div class="w-3 h-3 rounded-full bg-slate-900 border border-slate-800 mr-2"></div>
      <div class="w-2 h-2 rounded-full bg-emerald-500/80 animate-ping"></div>
    </div>

    <!-- Instagram/Reels Progress Bars Header (6 Scenes) -->
    <div class="absolute top-10 inset-x-4 z-40 flex items-center gap-1.5">
      <div class="h-1 flex-1 bg-white/30 rounded-full overflow-hidden"><div id="bar0" class="h-full bg-white w-0 transition-all duration-100"></div></div>
      <div class="h-1 flex-1 bg-white/30 rounded-full overflow-hidden"><div id="bar1" class="h-full bg-white w-0 transition-all duration-100"></div></div>
      <div class="h-1 flex-1 bg-white/30 rounded-full overflow-hidden"><div id="bar2" class="h-full bg-white w-0 transition-all duration-100"></div></div>
      <div class="h-1 flex-1 bg-white/30 rounded-full overflow-hidden"><div id="bar3" class="h-full bg-white w-0 transition-all duration-100"></div></div>
      <div class="h-1 flex-1 bg-white/30 rounded-full overflow-hidden"><div id="bar4" class="h-full bg-white w-0 transition-all duration-100"></div></div>
      <div class="h-1 flex-1 bg-white/30 rounded-full overflow-hidden"><div id="bar5" class="h-full bg-white w-0 transition-all duration-100"></div></div>
    </div>

    <!-- Reels Top Overlay Header -->
    <div class="absolute top-14 inset-x-4 z-30 flex items-center justify-between text-xs text-white/90 drop-shadow">
      <div class="flex items-center gap-2">
        <div class="w-7 h-7 rounded-full bg-emerald-600 flex items-center justify-center font-black text-xs shadow">🐑</div>
        <span class="font-bold text-xs tracking-tight">kashmir.sheeps</span>
        <span class="text-[10px] bg-white/20 backdrop-blur-sm px-2 py-0.2 rounded-full font-semibold">Verified Direct</span>
      </div>
      <div class="flex items-center gap-1 text-[11px] bg-black/40 backdrop-blur-md px-2.5 py-1 rounded-full border border-white/10 font-mono" id="timerDisplay">
        00:00 / 00:38
      </div>
    </div>

    <!-- MAIN SCENE DISPLAY VIEWPORT -->
    <div id="sceneContainer" class="relative w-full h-full overflow-hidden flex flex-col justify-between p-5 pt-20 pb-20">
      
      <!-- Background Visual Layer (Dynamically swapped) -->
      <div id="sceneBg" class="absolute inset-0 bg-cover bg-center transition-all duration-700 transform scale-105 filter brightness-75"></div>
      
      <!-- Gradient Scrim for text readability -->
      <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/90 pointer-events-none"></div>

      <!-- Content Area Top: Badge & Kinetic Typography -->
      <div class="relative z-20 space-y-2 mt-4">
        <div id="sceneBadge" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-500 text-slate-950 shadow-lg">
          Scene 1: The Problem
        </div>

        <h2 id="sceneHeading" class="text-2xl font-black text-white leading-tight drop-shadow-md">
          TIRED OF BROKER COMMISSIONS? ❌
        </h2>

        <p id="sceneUrdu" class="text-sm font-urdu text-amber-300 drop-shadow-md leading-relaxed">
          دلالوں کو کمیشن دینا بند کریں!
        </p>
      </div>

      <!-- Content Area Center: Highlight Feature Card -->
      <div id="sceneCenterCard" class="relative z-20 my-auto p-4 rounded-3xl bg-slate-900/85 backdrop-blur-md border border-white/15 shadow-2xl transition-all duration-500">
        <div class="flex items-center gap-3">
          <div id="cardIcon" class="w-14 h-14 rounded-2xl bg-emerald-600/20 text-emerald-400 flex items-center justify-center text-3xl font-black shrink-0 border border-emerald-500/30">
            🐑
          </div>
          <div>
            <span id="cardCategory" class="text-[10px] font-bold uppercase tracking-wider text-emerald-400 block">Kashmir Direct Mandi</span>
            <h4 id="cardTitle" class="text-sm font-black text-white leading-snug">Zero Middleman Farm Gate</h4>
            <span id="cardPrice" class="text-xs font-black text-amber-400 block mt-0.5">Farm-Gate Rates Verified</span>
          </div>
        </div>
        <p id="cardDesc" class="text-[11px] text-slate-300 mt-2.5 leading-relaxed">
          Connect directly with local shepherds for pure Kashmir Merino rams, Bakarwali mountain sheep, and organic manure.
        </p>
      </div>

      <!-- Content Area Bottom: Voiceover Subtitle & Beat Indicator -->
      <div class="relative z-20 space-y-3">
        <!-- Subtitles Bubble -->
        <div class="p-3 rounded-2xl bg-black/70 backdrop-blur-md border border-white/10 text-center">
          <p id="voiceoverSub" class="text-xs text-white/95 font-medium leading-relaxed">
            "Are you fed up with brokers taking massive cuts on livestock and orchard manure? No more!"
          </p>
        </div>

        <!-- Social Engagement Icons Right Float -->
        <div class="absolute right-2 bottom-20 flex flex-col items-center gap-3 text-white text-xs drop-shadow pointer-events-auto">
          <button class="flex flex-col items-center gap-1 group">
            <span class="w-10 h-10 rounded-full bg-black/40 backdrop-blur-md border border-white/20 flex items-center justify-center text-lg group-hover:scale-110 transition">❤️</span>
            <span class="text-[10px] font-bold">14.8K</span>
          </button>
          <button class="flex flex-col items-center gap-1 group">
            <span class="w-10 h-10 rounded-full bg-black/40 backdrop-blur-md border border-white/20 flex items-center justify-center text-lg group-hover:scale-110 transition">💬</span>
            <span class="text-[10px] font-bold">642</span>
          </button>
          <button class="flex flex-col items-center gap-1 group">
            <span class="w-10 h-10 rounded-full bg-black/40 backdrop-blur-md border border-white/20 flex items-center justify-center text-lg group-hover:scale-110 transition">↗️</span>
            <span class="text-[10px] font-bold">Share</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Bottom Persistent CTA Banner -->
    <div class="absolute bottom-3 inset-x-3 z-30 p-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white flex items-center justify-between shadow-xl cursor-pointer transition transform active:scale-95" onclick="window.location.href='/'">
      <div class="flex items-center gap-2">
        <span class="text-lg">🛒</span>
        <div>
          <span class="text-[11px] font-black uppercase tracking-wider block">Visit Marketplace</span>
          <span class="text-[10px] text-emerald-100 block">kashmirsheeps.com • Open App</span>
        </div>
      </div>
      <span class="text-sm font-bold bg-white text-emerald-950 w-7 h-7 rounded-xl flex items-center justify-center shadow">→</span>
    </div>

    <!-- Play / Pause Overlay Button on Tap -->
    <div id="playPauseOverlay" class="absolute inset-0 z-20 flex items-center justify-center bg-black/20 opacity-0 hover:opacity-100 transition cursor-pointer" onclick="togglePlay()">
      <div class="w-16 h-16 rounded-full bg-black/60 backdrop-blur-md border border-white/30 text-white flex items-center justify-center text-2xl shadow-2xl">
        <span id="centerPlayIcon">⏸️</span>
      </div>
    </div>
  </div>

  <!-- SCENE SCRUBBER TIMELINE -->
  <footer class="max-w-xl w-full mt-4 flex items-center justify-between text-xs text-slate-400 px-2">
    <span>🎬 Scene Navigation:</span>
    <div class="flex items-center gap-1.5">
      <button onclick="jumpToScene(0)" class="px-2 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 border border-slate-700 text-[11px] font-bold">1. Problem</button>
      <button onclick="jumpToScene(1)" class="px-2 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 border border-slate-700 text-[11px] font-bold">2. Reveal</button>
      <button onclick="jumpToScene(2)" class="px-2 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 border border-slate-700 text-[11px] font-bold">3. Manure</button>
      <button onclick="jumpToScene(3)" class="px-2 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 border border-slate-700 text-[11px] font-bold">4. Wool</button>
      <button onclick="jumpToScene(4)" class="px-2 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 border border-slate-700 text-[11px] font-bold">5. Sheep</button>
      <button onclick="jumpToScene(5)" class="px-2 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 border border-slate-700 text-[11px] font-bold">6. CTA</button>
    </div>
  </footer>

  <!-- JAVASCRIPT ANIMATION & AUDIO ENGINE -->
  <script>
    const scenes = [
      {
        duration: 4, // 0 - 4s
        badge: "0:00 - The Problem",
        badgeColor: "bg-red-500 text-white",
        heading: "TIRED OF BROKER COMMISSIONS? ❌",
        urdu: "دلالوں کو کمیشن دینا بند کریں!",
        bgImage: "https://images.unsplash.com/photo-1500595046743-cd271d694d30?auto=format&fit=crop&w=800&q=80",
        cardIcon: "🛑",
        cardCategory: "Traditional Mandi Brokerage",
        cardTitle: "Inflated Prices & No Health Verification",
        cardPrice: "Losses for Farmers & Buyers",
        cardDesc: "Brokers pocket ₹3,000–₹5,000 per head without medical or vaccination verification.",
        voiceover: '"Are you fed up with brokers taking massive cuts on livestock and orchard manure? No more!"'
      },
      {
        duration: 8, // 4 - 12s
        badge: "0:04 - The Digital Solution",
        badgeColor: "bg-emerald-500 text-slate-950",
        heading: "MEET KASHMIR SHEEPS 🐑",
        urdu: "کشمیر کی تاریخ میں پہلی بار آن لائن منڈی!",
        bgImage: "https://images.unsplash.com/photo-1516467508483-a7212febe31a?auto=format&fit=crop&w=800&q=80",
        cardIcon: "📱",
        cardCategory: "Direct Digital E-Mandi",
        cardTitle: "Zero Commissions • Direct From Shepherds",
        cardPrice: "Verified Farm-Gate Rates",
        cardDesc: "Browse pure Kashmir Merino studs, orchard manure, and virgin wool directly on your smartphone.",
        voiceover: '"For the first time in Kashmir history — Shepherds, apple growers, and buyers connect directly online!"'
      },
      {
        duration: 8, // 12 - 20s
        badge: "0:12 - Apple Orchard Fertilizer",
        badgeColor: "bg-amber-500 text-slate-950",
        heading: "🌱 ORGANIC SHEEP MANURE",
        urdu: "سیب کے باغات کیلئے دیسی کھاد ٹریکٹر ٹرالی!",
        bgImage: "https://images.unsplash.com/photo-1589923188900-85dae523342b?auto=format&fit=crop&w=800&q=80",
        cardIcon: "🚜",
        cardCategory: "Orchard Soil Nutrition",
        cardTitle: "Tractor Trolleys & 50 Kg Screened Bags",
        cardPrice: "From ₹450 / Bag • ₹4,500 / Trolley",
        cardDesc: "3x higher nitrogen than cow dung. Releases biological warmth protecting roots during Chillai Kalan (-8°C).",
        voiceover: '"Pure aged sheep manure for apple orchards — tractor trolleys and 50kg bags delivered right to your trees!"'
      },
      {
        duration: 8, // 20 - 28s
        badge: "0:20 - Pure Merino Wool & Yarn",
        badgeColor: "bg-purple-500 text-white",
        heading: "🧶 SUPERFINE MERINO WOOL",
        urdu: "چرخے کا کاتا ہوا خالص کشمیری سوت برائے فیرن!",
        bgImage: "https://images.unsplash.com/photo-1579783902614-a3fb3927b675?auto=format&fit=crop&w=800&q=80",
        cardIcon: "🧶",
        cardCategory: "Handicrafts & Weaving",
        cardTitle: "19.5 Micron Superfine Fleece & Yarn",
        cardPrice: "SKUAST-K Tested • 66% Clean Yield",
        cardDesc: "Hand-sheared spring clip fleece and charkha-spun yarn for warm winter Pherans, shawls, and tweeds.",
        voiceover: '"Superfine 19.5-micron fleece and charkha-spun yarn — the golden standard for handmade Pherans and tweeds!"'
      },
      {
        duration: 6, // 28 - 34s
        badge: "0:28 - Verified Livestock & Transit",
        badgeColor: "bg-emerald-600 text-white",
        heading: "🐑 VERIFIED BREEDING & QURBANI",
        urdu: "۱۲ ہندسی آریف آئی ڈی ٹیگ و ہیلتھ کارڈ!",
        bgImage: "https://images.unsplash.com/photo-1484557052118-f32bd25b45b5?auto=format&fit=crop&w=800&q=80",
        cardIcon: "🛡️",
        cardCategory: "Veterinary Clearance",
        cardTitle: "12-Digit INAPH Passports & Doorstep Transit",
        cardPrice: "Full ETV & Sheep Pox Immunized",
        cardDesc: "VAS clinical fitness verified. Safe caged vehicle transit delivered directly across all 10 Kashmir districts.",
        voiceover: '"Certified breeding rams, Qurbani stock, e-health passports, and safe doorstep delivery across all 10 districts!"'
      },
      {
        duration: 4, // 34 - 38s
        badge: "0:34 - Call to Action",
        badgeColor: "bg-amber-400 text-slate-950 font-black",
        heading: "🌐 KASHMIRSHEEPS.COM",
        urdu: "ابھی وزٹ کریں یا اپنا مفت اشتہار لگائیں!",
        bgImage: "https://images.unsplash.com/photo-1526030994690-40e26ad32a1c?auto=format&fit=crop&w=800&q=80",
        cardIcon: "✨",
        cardCategory: "Start Trading Today",
        cardTitle: "Kashmir's Online Livestock & Farm Store",
        cardPrice: "Free Farmer Registration",
        cardDesc: "Join thousands of shepherds, orchardists, and buyers. Tap below or visit KashmirSheeps.com today!",
        voiceover: '"Visit KashmirSheeps.com today — or post your free livestock listing now!"'
      }
    ];

    let currentSceneIdx = 0;
    let sceneTimer = 0;
    let totalElapsed = 0;
    let isPlaying = true;
    let audioEnabled = false;
    let audioCtx = null;

    function renderScene(idx) {
      const s = scenes[idx];
      document.getElementById('sceneBadge').textContent = s.badge;
      document.getElementById('sceneBadge').className = `inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider ${s.badgeColor} shadow-lg`;
      document.getElementById('sceneHeading').textContent = s.heading;
      document.getElementById('sceneUrdu').textContent = s.urdu;
      document.getElementById('sceneBg').style.backgroundImage = `url('${s.bgImage}')`;
      document.getElementById('cardIcon').textContent = s.cardIcon;
      document.getElementById('cardCategory').textContent = s.cardCategory;
      document.getElementById('cardTitle').textContent = s.cardTitle;
      document.getElementById('cardPrice').textContent = s.cardPrice;
      document.getElementById('cardDesc').textContent = s.cardDesc;
      document.getElementById('voiceoverSub').textContent = s.voiceover;

      // Pulse animation trigger
      const card = document.getElementById('sceneCenterCard');
      card.classList.remove('pulse-glow');
      void card.offsetWidth;
      card.classList.add('pulse-glow');
    }

    function jumpToScene(idx) {
      currentSceneIdx = idx;
      sceneTimer = 0;
      totalElapsed = scenes.slice(0, idx).reduce((acc, s) => acc + s.duration, 0);
      updateProgressBars();
      renderScene(currentSceneIdx);
    }

    function restartVideo() {
      currentSceneIdx = 0;
      sceneTimer = 0;
      totalElapsed = 0;
      isPlaying = true;
      document.getElementById('centerPlayIcon').textContent = "⏸️";
      updateProgressBars();
      renderScene(0);
    }

    function togglePlay() {
      isPlaying = !isPlaying;
      document.getElementById('centerPlayIcon').textContent = isPlaying ? "⏸️" : "▶️";
    }

    function updateProgressBars() {
      for (let i = 0; i < scenes.length; i++) {
        const bar = document.getElementById('bar' + i);
        if (i < currentSceneIdx) {
          bar.style.width = '100%';
        } else if (i === currentSceneIdx) {
          const pct = Math.min(100, (sceneTimer / scenes[i].duration) * 100);
          bar.style.width = pct + '%';
        } else {
          bar.style.width = '0%';
        }
      }

      // Update Timer
      const curSec = Math.floor(totalElapsed);
      const totalSec = 38;
      document.getElementById('timerDisplay').textContent = 
        `00:${curSec < 10 ? '0' + curSec : curSec} / 00:${totalSec}`;
    }

    // Audio synthesizer for Kashmiri Rabab & Lo-Fi Beat
    function toggleAudio() {
      audioEnabled = !audioEnabled;
      const btn = document.getElementById('audioToggleBtn');
      const icon = document.getElementById('audioIcon');
      const label = document.getElementById('audioLabel');

      if (audioEnabled) {
        if (!audioCtx) {
          audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        }
        btn.classList.add('bg-emerald-600', 'text-white', 'border-emerald-500');
        icon.textContent = "🔊";
        label.textContent = "Beat Playing";
        playRababChime(440);
      } else {
        btn.classList.remove('bg-emerald-600', 'text-white', 'border-emerald-500');
        icon.textContent = "🔇";
        label.textContent = "Beat Muted";
      }
    }

    function playRababChime(freq = 440) {
      if (!audioEnabled || !audioCtx) return;
      try {
        const osc = audioCtx.createOscillator();
        const gain = audioCtx.createGain();
        osc.type = 'triangle';
        osc.frequency.setValueAtTime(freq, audioCtx.currentTime);
        osc.frequency.exponentialRampToValueAtTime(freq * 1.5, audioCtx.currentTime + 0.15);
        gain.gain.setValueAtTime(0.15, audioCtx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.35);
        osc.connect(gain);
        gain.connect(audioCtx.destination);
        osc.start();
        osc.stop(audioCtx.currentTime + 0.35);
      } catch (e) {}
    }

    // Main 100ms Animation Loop
    setInterval(() => {
      if (!isPlaying) return;

      sceneTimer += 0.1;
      totalElapsed += 0.1;

      // Play subtle rhythmic beat
      if (Math.round(totalElapsed * 10) % 8 === 0 && audioEnabled) {
        playRababChime(currentSceneIdx % 2 === 0 ? 330 : 440);
      }

      if (sceneTimer >= scenes[currentSceneIdx].duration) {
        if (currentSceneIdx < scenes.length - 1) {
          currentSceneIdx++;
          sceneTimer = 0;
          renderScene(currentSceneIdx);
          playRababChime(587.33); // Scene change chime
        } else {
          // Loop restart
          restartVideo();
        }
      }

      updateProgressBars();
    }, 100);

    // Initial render
    renderScene(0);
  </script>
</body>
</html>
