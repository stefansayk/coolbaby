# a sealed Glutbart reached a player's inventory
clear @s *[minecraft:custom_data~{mythic_seal:"glutbart"}] 1
execute if score #glutbart mythic.forged matches 1.. run return run function mythic:legend/glutbart/denied
scoreboard players set #glutbart mythic.forged 1
loot give @s loot mythic:legend/glutbart
recipe take @a mythic:glutbart
tellraw @a ["",{"text":"✦ ","color":"gold"},{"selector":"@s","color":"white"},{"text":" hat die Legende ","color":"gray"},{"text": "Glutbart", "color": "#ff8a00", "bold": true},{"text":" geschmiedet! Es gibt sie nur dieses eine Mal.","color":"gray"}]
execute as @a at @s run playsound minecraft:ui.toast.challenge_complete master @s ~ ~ ~ 1 1
execute at @s run particle minecraft:totem_of_undying ~ ~1 ~ 0.5 0.8 0.5 0.4 60
