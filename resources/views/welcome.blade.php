<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wong Kirito - Pelacak Harga Kripto</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sunflower: '#FAD02C',
                        forest: '#0B664B',
                        offwhite: '#F6F4EB',
                        forestDark: '#074230'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0B664B;
        }
        
        .bento-card {
            background-color: #F6F4EB;
            border-radius: 1.25rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0,0,0,0.05);
        }

        /* Flash animations */
        @keyframes flashUp {
            0% { color: #10B981; } /* Emerald 500 */
            100% { color: #074230; } /* text-forestDark */
        }
        @keyframes flashDown {
            0% { color: #EF4444; } /* Red 500 */
            100% { color: #074230; }
        }
        
        .flash-up {
            animation: flashUp 1s ease-out;
        }
        .flash-down {
            animation: flashDown 1s ease-out;
        }
    </style>
</head>
<body class="text-forestDark flex items-center justify-center min-h-screen p-4 sm:p-8">

    <div class="max-w-4xl w-full">
        <!-- Header Section -->
        <div class="mb-10 text-left sm:text-center space-y-3">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-sunflower tracking-tight">
                Wong Kirito
            </h1>
            <p class="text-offwhite/90 font-medium text-lg">Platform khusus bagi yang sedang fokus Kiripto ( •̀ ω •́ )✧</p>
        </div>

        <!-- Bento Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            
            <!-- Search Compartment -->
            <div class="bento-card p-6 md:col-span-3 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex-grow w-full max-w-xl">
                    <label for="coinInput" class="block text-forest/70 text-xs font-bold uppercase tracking-wider mb-2">Cari Simbol Aset</label>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5 text-forest/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" id="coinInput" class="w-full bg-white border-2 border-forest/10 text-forestDark text-lg rounded-xl focus:ring-0 focus:border-sunflower block pl-12 pr-12 py-3 font-semibold transition-colors placeholder-forest/30" placeholder="Misal: BTC, SOL, ETH" autocomplete="off">
                        
                        <!-- Clear Button -->
                        <button type="button" id="clearBtn" class="absolute right-3 p-1.5 text-forest/40 hover:text-forest bg-forest/5 rounded-lg hover:bg-forest/10 transition-colors hidden" title="Hapus pencarian">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div id="statusIndicator" class="flex items-center space-x-2 bg-forest/5 px-4 py-2.5 rounded-xl border border-forest/10 whitespace-nowrap self-start sm:self-end">
                    <div class="w-3 h-3 rounded-full bg-gray-400" id="pollingDot"></div>
                    <span class="text-sm text-forest font-bold tracking-wide" id="pollingText">Siap</span>
                </div>
            </div>

            <!-- Price Indicator -->
            <div class="bento-card p-8 md:col-span-2 flex flex-col justify-between">
                <div>
                    <h2 class="text-forest/70 text-xs font-bold uppercase tracking-wider mb-1">Harga Saat Ini</h2>
                    <div id="coinSymbolDisplay" class="text-2xl font-black text-forest tracking-tight">---</div>
                </div>
                
                <div class="mt-6">
                    <div class="text-5xl sm:text-6xl font-black text-forestDark tracking-tighter" id="priceDisplay">$0.00</div>
                    <div class="text-red-600 text-sm mt-3 font-semibold hidden bg-red-50 p-3 rounded-lg border border-red-100" id="errorMessage"></div>
                </div>
            </div>

            <!-- 24h & Updates -->
            <div class="grid grid-rows-2 gap-5 md:col-span-1">
                <!-- 24h Percentage -->
                <div class="bento-card p-6 flex flex-col justify-center">
                    <h2 class="text-forest/70 text-xs font-bold uppercase tracking-wider mb-2">Perubahan 24 Jam</h2>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="text-3xl font-black text-forest/30" id="pctDisplay">0.00%</span>
                        <div class="p-1.5 rounded-lg hidden" id="trendIconWrapper">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="trendIcon"></svg>
                        </div>
                    </div>
                </div>

                <!-- Last Updated -->
                <div class="bento-card p-6 flex flex-col justify-center">
                    <h2 class="text-forest/70 text-xs font-bold uppercase tracking-wider mb-2">Pembaruan Terakhir</h2>
                    <span class="text-xl font-bold text-forestDark" id="timeDisplay">--:--:--</span>
                </div>
            </div>

        </div>
        
        <div class="mt-8 text-center sm:text-right">
            <p class="text-offwhite/50 text-sm font-medium">Pengembang: Fajar Ilham Arifiyanto</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const coinInput = document.getElementById('coinInput');
            const clearBtn = document.getElementById('clearBtn');
            const priceDisplay = document.getElementById('priceDisplay');
            const pctDisplay = document.getElementById('pctDisplay');
            const timeDisplay = document.getElementById('timeDisplay');
            const errorMessage = document.getElementById('errorMessage');
            const coinSymbolDisplay = document.getElementById('coinSymbolDisplay');
            
            const pollingDot = document.getElementById('pollingDot');
            const pollingText = document.getElementById('pollingText');
            const trendIconWrapper = document.getElementById('trendIconWrapper');
            const trendIcon = document.getElementById('trendIcon');

            let debounceTimer;
            let pollingTimer;
            let currentSymbol = '';
            let lastPrice = null;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Formatter for currency
            const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 2,
                maximumFractionDigits: 8
            });

            const resetUI = () => {
                currentSymbol = '';
                lastPrice = null;
                coinInput.value = '';
                priceDisplay.textContent = '$0.00';
                pctDisplay.textContent = '0.00%';
                pctDisplay.className = 'text-3xl font-black text-forest/30';
                coinSymbolDisplay.textContent = '---';
                timeDisplay.textContent = '--:--:--';
                errorMessage.classList.add('hidden');
                trendIconWrapper.classList.add('hidden');
                clearBtn.classList.add('hidden');
                setStatus('waiting');
                
                clearTimeout(debounceTimer);
                clearInterval(pollingTimer);
            };

            // Event listener for Clear button
            clearBtn.addEventListener('click', () => {
                resetUI();
                coinInput.focus();
            });

            // Set polling status
            const setStatus = (status) => {
                if(status === 'active') {
                    pollingDot.className = 'w-3 h-3 rounded-full bg-sunflower';
                    pollingText.textContent = 'Memantau';
                    pollingText.className = 'text-sm text-forest font-bold tracking-wide';
                } else if(status === 'error') {
                    pollingDot.className = 'w-3 h-3 rounded-full bg-red-500';
                    pollingText.textContent = 'Gagal';
                    pollingText.className = 'text-sm text-red-600 font-bold tracking-wide';
                } else {
                    pollingDot.className = 'w-3 h-3 rounded-full bg-gray-400';
                    pollingText.textContent = 'Siap';
                    pollingText.className = 'text-sm text-forest/60 font-bold tracking-wide';
                }
            };

            // Fetch Data Function
            const fetchCoinData = async (symbol) => {
                if (!symbol) return;
                
                try {
                    const response = await fetch('/ajax/get-coin-price', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ symbol: symbol })
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.error || 'Aset tidak ditemukan');
                    }

                    // Success handling
                    errorMessage.classList.add('hidden');
                    coinSymbolDisplay.textContent = data.symbol;
                    
                    const newPrice = parseFloat(data.lastPrice);
                    const priceFormatted = formatter.format(newPrice);
                    
                    // Flash Indicator Logic
                    if (lastPrice !== null && newPrice !== lastPrice) {
                        priceDisplay.classList.remove('flash-up', 'flash-down');
                        void priceDisplay.offsetWidth; // Trigger DOM reflow
                        
                        if (newPrice > lastPrice) {
                            priceDisplay.classList.add('flash-up');
                        } else {
                            priceDisplay.classList.add('flash-down');
                        }
                    }
                    
                    priceDisplay.textContent = priceFormatted;
                    lastPrice = newPrice;

                    // Percentage logic
                    const pct = parseFloat(data.priceChangePercent);
                    pctDisplay.textContent = (pct > 0 ? '+' : '') + pct.toFixed(2) + '%';
                    
                    trendIconWrapper.classList.remove('hidden');
                    if (pct > 0) {
                        pctDisplay.className = 'text-3xl font-black text-green-600';
                        trendIconWrapper.className = 'p-1.5 rounded-lg bg-green-100 text-green-600';
                        trendIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />';
                    } else if (pct < 0) {
                        pctDisplay.className = 'text-3xl font-black text-red-600';
                        trendIconWrapper.className = 'p-1.5 rounded-lg bg-red-100 text-red-600';
                        trendIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />';
                    } else {
                        pctDisplay.className = 'text-3xl font-black text-forestDark';
                        trendIconWrapper.classList.add('hidden');
                    }

                    // Update Time
                    const now = new Date();
                    timeDisplay.textContent = now.toLocaleTimeString('id-ID', { hour12: false });
                    
                    setStatus('active');

                } catch (error) {
                    errorMessage.textContent = error.message;
                    errorMessage.classList.remove('hidden');
                    setStatus('error');
                    
                    if(!lastPrice) {
                        priceDisplay.textContent = '---';
                        pctDisplay.textContent = '---';
                        pctDisplay.className = 'text-3xl font-black text-forest/30';
                        trendIconWrapper.classList.add('hidden');
                        coinSymbolDisplay.textContent = symbol.toUpperCase();
                    }
                }
            };

            // Input Event Listener with Debounce
            coinInput.addEventListener('input', (e) => {
                const val = e.target.value.trim();
                
                clearTimeout(debounceTimer);
                clearInterval(pollingTimer);
                
                if (val.length > 0) {
                    clearBtn.classList.remove('hidden');
                    setStatus('waiting');
                } else {
                    resetUI();
                    return;
                }

                debounceTimer = setTimeout(() => {
                    currentSymbol = val;
                    lastPrice = null; 
                    priceDisplay.classList.remove('flash-up', 'flash-down');
                    
                    fetchCoinData(currentSymbol);
                    
                    pollingTimer = setInterval(() => {
                        fetchCoinData(currentSymbol);
                    }, 5000);
                    
                }, 500); 
            });
        });
    </script>
</body>
</html>
