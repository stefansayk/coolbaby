# testing only: gives the legend without forging it (does not count as crafted)
loot give @s loot mythic:legend/seelenernter
tellraw @s ["",{"text":"[Test] ","color":"dark_gray"},{"text": "Seelenernter", "color": "#ff2a5a", "bold": true},{"text":" erhalten (zählt nicht als geschmiedet).","color":"gray"}]
