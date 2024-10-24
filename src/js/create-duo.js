const form = document.getElementById('create-duo-form');

async function getDuo() {
  const { data: { duoPlayer } } = await axios.get("http://localhost:3000/duo");

  return duoPlayer;
}

async function createDuo({ player_one_id, player_two_id }) {
  await axios.post("http://localhost:3000/duo", {player_one_id, player_two_id})
}

form.addEventListener("submit", async (e) => {
  e.preventDefault();

  const { value: playerOne } = document.querySelector("#select-player-one");
  const { value: playerTwo } = document.querySelector("#select-player-two");

  const duos = await getDuo();

  if(playerOne === playerTwo) {
    alert("Não pode ter dupla com mesmo jogador")
    return;
  }

  const isDuoExistent = duos.some(duo => {
    if((duo.player_one_id === Number(playerOne) || duo.player_two_id === Number(playerOne)) && (duo.player_one_id === Number(playerTwo) || duo.player_two_id === Number(playerTwo))) {
      return true;
    }
  });

  if (isDuoExistent) { return alert("Dupla ja existe") }

  await createDuo({ player_one_id: Number(playerOne), player_two_id: Number(playerTwo) });

  alert("dupla criada com sucesso");
})