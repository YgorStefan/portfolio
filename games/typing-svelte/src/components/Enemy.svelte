<script>
    export let enemy;

    const COLORS = [
        "#06b6d4",
        "#22c55e",
        "#a855f7",
        "#f97316",
        "#ec4899",
        "#ef4444",
        "#eab308",
    ];

    $: color = COLORS[enemy.type ?? 0];
</script>

<div class="enemy" style="left: {enemy.x}px; top: {enemy.y}px">
    <svg
        width="60"
        height="50"
        viewBox="0 0 60 50"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <!-- Antenas -->
        <line
            x1="23"
            y1="13"
            x2="17"
            y2="4"
            stroke={color}
            stroke-width="1.5"
            stroke-linecap="round"
        />
        <circle cx="16" cy="3" r="2.5" fill={color} />
        <line
            x1="37"
            y1="13"
            x2="43"
            y2="4"
            stroke={color}
            stroke-width="1.5"
            stroke-linecap="round"
        />
        <circle cx="44" cy="3" r="2.5" fill={color} />

        <!-- Corpo do alien -->
        <ellipse cx="30" cy="21" rx="13" ry="11" fill={color} opacity="0.9" />
        <!-- Olhos -->
        <circle cx="25" cy="18" r="3.5" fill="white" />
        <circle cx="35" cy="18" r="3.5" fill="white" />
        <circle cx="26" cy="19" r="1.8" fill="#111" />
        <circle cx="36" cy="19" r="1.8" fill="#111" />
        <!-- Sorriso -->
        <path
            d="M24 26 Q30 30 36 26"
            stroke="white"
            stroke-width="1.5"
            fill="none"
            stroke-linecap="round"
        />

        <!-- Disco - sombra de profundidade -->
        <ellipse cx="30" cy="39" rx="28" ry="8" fill={color} opacity="0.18" />
        <!-- Disco - superfície principal -->
        <ellipse
            cx="30"
            cy="37"
            rx="28"
            ry="8"
            fill="#0f172a"
            stroke={color}
            stroke-width="1.5"
        />
        <!-- Luzes do disco -->
        <circle cx="10" cy="37" r="2.5" fill={color} opacity="0.9" />
        <circle cx="20" cy="41" r="2.5" fill={color} opacity="0.75" />
        <circle cx="30" cy="42" r="2.5" fill={color} />
        <circle cx="40" cy="41" r="2.5" fill={color} opacity="0.75" />
        <circle cx="50" cy="37" r="2.5" fill={color} opacity="0.9" />
    </svg>
    <div class="command">{enemy.command}</div>
</div>

<style>
    .enemy {
        position: absolute;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        pointer-events: none;
    }
    .command {
        background: #011520;
        border: 1px solid #0a3a50;
        color: #06b6d4;
        font-family: "Courier New", monospace;
        font-size: 0.78rem;
        padding: 2px 8px;
        border-radius: 4px;
        white-space: nowrap;
    }
</style>
