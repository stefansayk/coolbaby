# the legend already exists: break the seal, give the materials back
loot give @s loot mythic:refund/tiefseejaeger
tellraw @s ["",{"text":"✦ ","color":"dark_red"},{"text": "Tiefseejäger", "color": "#3a8cff", "bold": true},{"text":" existiert bereits in dieser Welt. Das Siegel zerbricht, du bekommst deine Materialien zurück.","color":"gray"}]
execute at @s run playsound minecraft:block.glass.break master @s ~ ~ ~ 1 0.6
