const form = document.querySelector("#create-single-match-form");

async function createSingleMatch({ player_one_id, player_two_id, result }) {
  await axios.post("http://localhost:3000/single", { player_one_id, player_two_id, result })
}

async function updateRating({id, rating}) {
  await axios.patch(`http://localhost:3000/player/rating/${id}`, { rating })
}

form.addEventListener("submit", async (event) => {
  event.preventDefault();

  const winner = JSON.parse(document.querySelector("#select-winner").value);
  const loser = JSON.parse(document.querySelector("#select-loser").value);

  if(winner.id === loser.id) {
    return alert("Não pode uma partida com mesmo jogador");
  }

  if (winner.rating > loser.rating) {
    let matchRating = 20 - Math.floor(((winner.rating - loser.rating)) / 100) * 5;

    matchRating = matchRating <= 0 ? 5 : matchRating;

    winner.rating = winner.rating + matchRating;

    loser.rating -= matchRating;
  }

  if (winner.rating < loser.rating) {
    let matchRating = 20 + Math.floor(((loser.rating - winner.rating)) / 100) * 5;

    winner.rating += matchRating;

    loser.rating -= matchRating;
  }

  if(Math.floor(((winner.rating - loser.rating)) / 100) === 0) {
    winner.rating += 20;
    loser.rating -= 20;
  }

  await updateRating({id: Number(winner.id), rating: winner.rating });
  await updateRating({id: Number(loser.id), rating: loser.rating });

  await createSingleMatch({player_one_id: Number(winner.id), player_two_id: Number(loser.id),  result: Number(winner.id)})

  alert("Partida criada com sucesso");
})