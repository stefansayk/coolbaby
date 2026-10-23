# runs every 5 ticks
execute as @a[gamemode=!spectator] run function mythic:check
execute as @a[gamemode=!spectator] at @s run function mythic:held
scoreboard players enable @a mythic.status
execute as @a[scores={mythic.status=1..}] run function mythic:status
scoreboard players set @a[scores={mythic.status=1..}] mythic.status 0
schedule function mythic:loop 5t replace
