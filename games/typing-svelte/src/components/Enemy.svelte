<script>
  export let enemy
</script>

<div
  class="enemy"
  style="left: {enemy.x}px; top: {enemy.y}px"
>
  <div class="alien">👾</div>
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
.alien { font-size: 2rem; line-height: 1; }
.command {
  background: #1e293b;
  border: 1px solid #334155;
  color: #38bdf8;
  font-family: 'Courier New', monospace;
  font-size: 0.78rem;
  padding: 2px 8px;
  border-radius: 4px;
  white-space: nowrap;
}
</style>
