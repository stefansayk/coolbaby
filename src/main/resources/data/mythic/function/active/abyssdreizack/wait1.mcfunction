scoreboard players operation @s mythic.tmp = @s mythic.cd.abyssdreizack.1
scoreboard players operation @s mythic.tmp /= #20 mythic.const
scoreboard players add @s mythic.tmp 1
title @s actionbar ["",{"text":"Gewittersturm","color":"#8a6aff"},{"text":" lädt noch ","color":"gray"},{"score":{"name":"@s","objective":"mythic.tmp"},"color":"white"},{"text":" s","color":"gray"}]
playsound minecraft:block.note_block.bass master @s ~ ~ ~ 0.5 0.6
